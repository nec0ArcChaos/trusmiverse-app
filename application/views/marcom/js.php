<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>
<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<!-- Fancybox -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>


<!-- MAIN JS -->
<script>
    const baseUrl = "<?= base_url('marcom'); ?>";
    const userId = parseInt("<?= $this->session->userdata('user_id'); ?>");
    const userRole = parseInt("<?= $this->session->userdata('user_role_id'); ?>");

    let kanbanData = [];
    let slimPicSelect;
    let slimPicSelectReviewSpv;

    let placementSelect = new SlimSelect({
        select: '#placementSelect',
        settings: {
            showSearch: true,
            searchText: 'Cari Placement...',
            placeholderText: 'Pilih Placement...',
            allowDeselect: true,
            closeOnSelect: true,
        }
    })

    let outputSelect = new SlimSelect({
        select: '#outputSelect',
        settings: {
            showSearch: true,
            searchText: 'Cari Akun...',
            placeholderText: 'Pilih Akun...',
            allowDeselect: true,
            closeOnSelect: true,
        }
    })

    // Helper: Cek Permissions
    function canApproveAction() {
        const allowedRoles = [1, 2, 3, 4, 5];
        const allowedUsers = [1];

        return allowedRoles.includes(userRole) || allowedUsers.includes(userId);
    }


    $(document).ready(function() {

        const uri = window.location.href;
        const uriSegments = uri.split('/');
        const type = uriSegments[uriSegments.length - 1];

        if (type == 2) {
            loadKanbanData(5)
        }

        $('#companySelect').on('change', function() {
            const company_id = $(this).val();
            const $picSelect = $('#picSelect');
            $picSelect.empty();
            if (slimPicSelect) slimPicSelect.setData([]);

            if (!company_id) return;

            $.ajax({
                url: baseUrl + "/get_pic_by_company",
                type: "POST",
                data: {
                    company_id
                },
                dataType: "json",
                success: function(res) {
                    const options = res.map(row => ({
                        text: row.full_name + '|' + row.designation_name,
                        value: row.user_id
                    }));
                    if (slimPicSelect) {
                        slimPicSelect.setData(options);
                    } else {
                        slimPicSelect = new SlimSelect({
                            select: '#picSelect',
                            data: options,
                            settings: {
                                showSearch: true,
                                searchText: 'Cari PIC...',
                                placeholderText: 'Pilih PIC...',
                                allowDeselect: true,
                                closeOnSelect: true,
                                // TAMBAHAN: Render di dalam modal Campaign
                                contentLocation: document.getElementById('campaignModal')
                            }
                        });
                    }
                }
            });
        });

        // Init SlimSelect saat modal tampil
        $('#campaignModal').on('shown.bs.modal', function() {
            if (!slimPicSelect) {
                slimPicSelect = new SlimSelect({
                    select: '#picSelect',
                    settings: {
                        showSearch: true,
                        searchText: 'Cari PIC...',
                        placeholderText: 'Pilih PIC...',
                        allowDeselect: true,
                        closeOnSelect: true,
                        // TAMBAHAN: Render di dalam modal Campaign
                        contentLocation: document.getElementById('campaignModal')
                    }
                });
            }
        });

        // Destroy SlimSelect saat modal ditutup
        $('#campaignModal').on('hidden.bs.modal', function() {
            if (slimPicSelect) {
                slimPicSelect.destroy();
                slimPicSelect = null;
            }
            $('#picSelect').empty();
            $('#companySelect').val('').trigger('change');
        });


    });

    let uploadedFiles = [];
    let dzMarcom;

    Dropzone.autoDiscover = false;

    dzMarcom = new Dropzone("#marcomDropzone", {
        url: "<?= base_url('marcom/upload_temp_files'); ?>",
        maxFiles: 3,
        maxFilesize: 5, // MB
        acceptedFiles: ".jpg,.jpeg,.png,.pdf",
        addRemoveLinks: true,
        dictRemoveFile: "<i class='fa fa-trash'></i>",
        init: function() {
            this.on("success", function(file, response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status) {
                        uploadedFiles.push(res.filename);
                        // console.log("Uploaded:", uploadedFiles);
                    }
                } catch (e) {
                    console.log("Response error:", e);
                }
            });

            this.on("removedfile", function(file) {
                // Buang filename dari array
                let name = file.upload.filename;
                uploadedFiles = uploadedFiles.filter(f => f !== name);
                // console.log("After remove:", uploadedFiles);
            });

            this.on("maxfilesexceeded", function(file) {
                this.removeFile(file);
                $.confirm({
                    icon: 'fa fa-times-circle',
                    title: 'Warning',
                    theme: 'material',
                    type: 'red',
                    content: 'Anda hanya dapat mengunggah maksimal 3 file.',
                    buttons: {
                        close: {
                            actions: function() {}
                        },
                    },
                });
            });
        }
    });

    let kolTable;

    function loadKOLRef(placement) {
        // if (placement != 3 && placement != 4) {
        //     $('#tableKOL').closest('.table-responsive').hide();
        //     return;
        // }

        listPlacement = placement.join(",");

        // console.log(listPlacement);
        // return;

        $('#tableKOL').closest('.table-responsive').show();

        if ($.fn.DataTable.isDataTable('#tableKOL')) {
            kolTable.destroy();
        }

        kolTable = $('#tableKOL').DataTable({
            processing: true,
            lengthChange: false,
            ajax: {
                url: "<?= base_url('marcom/get_kol_list'); ?>",
                type: "POST",
                data: {
                    kategory: listPlacement
                }
            },
            columns: [{
                    data: "nama"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let akunTiktok = row.link_tt;
                        let akunInstagram = row.link_ig;

                        return `
                            <div>
                                ${akunTiktok ? `<a href="${akunTiktok}" target="_blank"><i class="fab fa-tiktok"></i> TikTok</a><br>` : ''}
                                ${akunInstagram ? `<a href="${akunInstagram}" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>` : ''}
                            </div>
                        `;
                    }
                },
                {
                    data: "ratecard",
                    render: d => "Rp " + new Intl.NumberFormat().format(d)
                },
                {
                    data: null,
                    render: d => `
                    <input type="checkbox" class="kol-check"
                        data-id="${d.id}" 
                        data-rate="${d.ratecard}">
                `
                }
            ]
        });
    }


    $("#placementSelect").on("change", function() {

        if ($(this).val() != '') {
            $('#kolContainer').removeClass('d-none');
        }
        let kategories = $(this).val();

        loadKOLRef(kategories);
    });


    $(document).on("change", ".kol-check", function() {
        let ids = [];
        let budgets = [];
        let namaKol = [];

        $(".kol-check:checked").each(function() {
            ids.push($(this).data("id"));
            budgets.push($(this).data("rate"));
            namaKol.push($(this).closest('tr').find('td:first').text());
        });

        let totalBudget = budgets.reduce((a, b) => a + b, 0);
        totalBudgetString = formatCurrencyDisplay(totalBudget);


        $("#kol_id").val(ids.join(","));
        $("#kol_budget").val(totalBudgetString);
        $("#kol_name").val(namaKol.join(", "));
    });


    $('#campaignModal').on('hidden.bs.modal', function() {
        dzMarcom.removeAllFiles(true);
        uploadedFiles = [];
    });



    // =============== TIMELINE (DATERANGEPICKER) SET DEFAULT TODAY ============
    $('#timelinePicker').daterangepicker({
        autoUpdateInput: true,
        startDate: moment(),
        endDate: moment(),
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'Pilih',
            cancelLabel: 'Batal'
        }
    }, function(start, end) {
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
    });

    // Set initial values
    $('#start_date').val(moment().format('YYYY-MM-DD'));
    $('#end_date').val(moment().format('YYYY-MM-DD'));


    // Init Summernote
    $('.summernote').summernote({
        placeholder: 'Tuliskan sesuatu di sini...',
        height: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol']]
        ],
    });

    $("#campaignForm").submit(function(e) {
        e.preventDefault();

        // --- 1. VALIDASI INPUTAN ---



        // A. Validasi Text Input Standard
        if ($.trim($('input[name="campaign_name"]').val()) == '') {
            showValidasi('Nama Campaign tidak boleh kosong!');
            return;
        }
        if ($.trim($('input[name="goals"]').val()) == '') {
            showValidasi('Goals tidak boleh kosong!');
            return;
        }
        if ($.trim($('input[name="big_idea"]').val()) == '') {
            showValidasi('Big Idea tidak boleh kosong!');
            return;
        }

        // B. Validasi Dropdown (Select)
        if ($('#companySelect').val() == '') {
            showValidasi('Silakan pilih Company!');
            return;
        }

        // C. Validasi PIC (Multiple Select)
        let picVal = $('#picSelect').val();
        if (!picVal || picVal.length === 0) {
            showValidasi('Silakan pilih minimal satu PIC!');
            return;
        }

        // D. Validasi Summernote (Deskripsi)
        if ($('#descriptionInput').summernote('isEmpty')) {
            showValidasi('Deskripsi Campaign tidak boleh kosong!');
            return;
        }

        // E. Validasi Timeline & Prioritas
        if ($('#timelinePicker').val() == '') {
            showValidasi('Timeline tidak boleh kosong!');
            return;
        }
        if ($('#priority').val() == '') {
            showValidasi('Silakan pilih Prioritas!');
            return;
        }

        let placementVal = $('#placementSelect').val();
        if (!placementVal || placementVal.length === 0) {
            showValidasi('Silakan pilih Placement!');
            return;
        }


        // 2. Cek apakah File sudah diupload (minimal 1)
        // Asumsi: variable 'uploadedFiles' adalah array global yang menampung nama file dari Dropzone
        if (uploadedFiles.length === 0) {
            showValidasi('Wajib upload minimal satu file lampiran!');
            return;
        }

        // --- AKHIR VALIDASI ---


        // 2. PROSES SIMPAN (Jika lolos validasi)
        let formData = new FormData(this);

        formData.append("pic", $("#picSelect").val().join(","));
        formData.append("placement", $("#placementSelect").val().join(","));
        formData.append("start_date", $("#start_date").val());
        formData.append("end_date", $("#end_date").val());

        // Append file yang ada di array uploadedFiles
        uploadedFiles.forEach((f, i) => {
            formData.append("uploaded_files[]", f);
        });

        $.ajax({
            url: "<?= base_url('marcom/create_campaign'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    dzMarcom.removeAllFiles(true);
                    uploadedFiles = [];
                    $("#campaignModal").modal("hide");
                    // Reset Form
                    $("#campaignForm")[0].reset();
                    $('#descriptionInput').summernote('reset');
                    if (slimPicSelect) slimPicSelect.setData([]);
                    $('#companySelect').val('').trigger('change');

                    loadCampaignList();
                    renderKanban(1);
                    initDragula(1)
                    $.confirm({
                        icon: 'fa fa-check-circle',
                        title: 'Success',
                        theme: 'material',
                        type: 'green',
                        content: 'Campaign berhasil disimpan.',
                        buttons: {
                            close: {
                                actions: function() {}
                            },
                        },
                    });
                } else {
                    $.confirm({
                        icon: 'fa fa-times-circle',
                        title: 'Error',
                        theme: 'material',
                        type: 'red',
                        content: res.message || 'Gagal menyimpan campaign.',
                        buttons: {
                            close: {
                                actions: function() {}
                            },
                        },
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $.alert('Terjadi kesalahan sistem.');
            }
        });
    });



    $(document).on('click', '#addLink', function() {
        let count = $('#linkWrapper .attach-link-box').length;
        if (count >= 3) return $.confirm({
            icon: 'fa fa-times-circle',
            title: 'Warning',
            theme: 'material',
            type: 'red',
            content: 'Maksimal 3 link saja.',
            buttons: {
                close: {
                    actions: function() {}
                },
            },
        });

        $('#linkWrapper').append(`
        <div class="attach-link-box mt-2 d-flex align-items-center">
            <i class="bi bi-link-45deg me-2"></i>
            <span class="small me-2">Benchmarking</span>
            <input type="text" name="reference_url[]" class="form-control form-control-sm"
                   placeholder="Tempel URL lengkap">
            <button type="button" class="btn btn-sm btn-danger ms-2 remove-link"><i class="bi bi-x"></i></button>
        </div>
    `);
    });

    $(document).on('click', '.remove-link', function() {
        $(this).closest('.attach-link-box').remove();
    });

    // --- HELPER UNTUK RENDER LINK & FILE DENGAN FANCYBOX ---

    Fancybox.bind("[data-fancybox]", {
        // Options
    });
</script>

<!-- helper function -->
<script>
    function showDeadline(val, company, element) {
        let $el = $(`#${element}`);

        if (company == 3) {
            $el.prop('readonly', true);
            $el.val(val);
        } else {
            $el.prop('readonly', false);
            $el.val('');
        }
    }



    function showLoader({
        text = 'Loading...',
        type = 'spinner', // spinner | dots | border
        position = 'append', // append | prepend | before | after
        target = 'body', // where to insert
        overlay = true, // overlay background
        shadow = false, // shadow box
        id = 'global_loader' // unique ID for closing later
    } = {}) {

        // Remove old loader with same ID if exists
        $('#' + id).remove();

        // Loader styles
        const loaderMap = {
            spinner: '<div class="spinner-border text-primary" role="status"></div>',
            border: '<div class="spinner-grow text-primary" role="status"></div>',
            dots: `
                <div class="loading-dots">
                    <span>.</span><span>.</span><span>.</span>
                </div>
            `
        };

        const loaderIcon = loaderMap[type] || loaderMap.spinner;

        const $loader = $(`
            <div id="${id}" class="custom-loader-overlay ${overlay ? 'with-overlay' : ''}">
                <div class="custom-loader-box ${shadow ? 'shadow-sm' : ''} text-center">
                    ${loaderIcon}
                    <div class="mt-2 fw-semibold">${text}</div>
                </div>
            </div>
        `);

        // Insert loader
        const $target = $(target);
        switch (position) {
            case 'prepend':
                $loader.prependTo($target);
                break;
            case 'before':
                $loader.insertBefore($target);
                break;
            case 'after':
                $loader.insertAfter($target);
                break;
            case 'replace':
                $target.html($loader);
                break;
            default:
                $loader.appendTo($target);
                break;
        }
    }

    function hideLoader(id = 'global_loader') {
        $('#' + id).fadeOut(300, function() {
            $(this).remove();
        });
    }

    // ===============================
    // 🛠️ HELPER FORMATTERS (REFACTORED)
    // ===============================

    /**
     * 1. Format Angka untuk Tampilan Text (Label/Span)
     * Output: "1.000", "1.500.000"
     */
    function formatNumberDisplay(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    /**
     * 2. Format Mata Uang untuk Tampilan Text (Label/Span)
     * Output: "Rp 1.000", "Rp 1.500.000"
     */
    function formatCurrencyDisplay(num) {
        return new Intl.NumberFormat('id', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(num);
    }

    /**
     * 3. Format Input Field saat mengetik (oninput)
     * Menghapus karakter non-digit dan memformat ulang
     * Output di Input: "1.000.000" (Tanpa 'Rp' agar mudah diedit)
     */
    function formatInputNumber(input) {
        let value = input.value.replace(/\D/g, ''); // Hapus non-digit
        if (value === '') {
            input.value = '';
            return;
        }
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    function formatInputCurrency(input) {
        let value = input.value.replace(/\D/g, ''); // Hapus non-digit
        if (value === '') {
            input.value = '';
            return;
        }
        input.value = new Intl.NumberFormat('id', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
    }

    /**
     * Render Links dengan Icon (Tanpa Fancybox)
     * @param {string|array} linksData - String "link1,link2" atau Array
     * @param {string} containerId - Target container ID
     */
    function renderLinks(linksStr, containerId) {
        if (!linksStr) {
            $(containerId).html('<span class="text-muted small fst-italic">- Tidak ada link -</span>');
            return;
        }

        // Handle jika string dipisah koma atau array
        let arr = Array.isArray(linksStr) ? linksStr : linksStr.split(',');
        let html = '';

        arr.forEach((l, idx) => {
            if (l && l.trim() !== '') {
                html += `
                <div class="file-item d-flex align-items-center gap-2 mb-2 p-2 border rounded bg-white">
                    <i class="bi bi-link-45deg text-primary" style="font-size: 20px;"></i>
                    <a href="${l.trim()}" target="_blank" class="text-decoration-none text-dark small flex-grow-1 text-truncate" title="${l.trim()}">
                        Link Referensi ${idx + 1}
                    </a>
                    <a href="${l.trim()}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>`;
            }
        });

        $(containerId).html(html || '<span class="text-muted small fst-italic">- Tidak ada link -</span>');
    }

    /**
     * Render Files dengan Fancybox Preview
     * @param {string|array} filesData - String "file1,file2" atau Array
     * @param {string} containerId - Target container ID
     * @param {string} basePath - Base URL path untuk files
     */
    function renderFiles(filesStr, containerId, basePath) {
        if (!filesStr) {
            $(containerId).html('<span class="text-muted small fst-italic">- Tidak ada file -</span>');
            return;
        }

        let arr = Array.isArray(filesStr) ? filesStr : filesStr.split(',');
        let html = '';

        arr.forEach((f, idx) => {
            if (f && f.trim() !== '') {
                let fileName = f.trim();
                let fileUrl = basePath + fileName;
                let fileExt = fileName.split('.').pop().toLowerCase();

                // Tentukan icon berdasarkan extension
                let icon = 'bi-file-earmark';
                let iconColor = 'text-secondary';
                let canPreview = false;

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                    icon = 'bi-file-image';
                    iconColor = 'text-success';
                    canPreview = true;
                } else if (fileExt === 'pdf') {
                    icon = 'bi-file-pdf';
                    iconColor = 'text-danger';
                    canPreview = true;
                } else if (['doc', 'docx'].includes(fileExt)) {
                    icon = 'bi-file-word';
                    iconColor = 'text-primary';
                } else if (['xls', 'xlsx'].includes(fileExt)) {
                    icon = 'bi-file-excel';
                    iconColor = 'text-success';
                }

                html += `
                <div class="file-item d-flex align-items-center gap-2 mb-2 p-2 border rounded bg-white">
                    <i class="bi ${icon} ${iconColor}" style="font-size: 20px;"></i>
                    <span class="small flex-grow-1 text-truncate" title="${fileName}">${fileName}</span>
                    ${canPreview ? 
                        `<a href="${fileUrl}" data-fancybox="gallery-${containerId.replace('#','')}" data-caption="${fileName}" class="btn btn-sm btn-outline-info py-0 px-2" title="Preview">
                            <i class="bi bi-eye"></i>
                        </a>` : 
                        `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-secondary py-0 px-2" title="Download">
                            <i class="bi bi-download"></i>
                        </a>`
                    }
                </div>`;
            }
        });

        $(containerId).html(html || '<span class="text-muted small fst-italic">- Tidak ada file -</span>');
    }

    function renderInfluencerInfo(dataArr, containerId) {
        let html = '';

        // Pastikan dataArr adalah array
        if (!Array.isArray(dataArr)) return $(containerId).hide();

        dataArr.forEach(data => {

            html += `
            <div class="alert alert-info border-info p-2 mb-0 shadow-sm d-flex justify-content-between align-items-center my-2">
                <div>
                    <small class="d-block text-muted fw-bold mb-1"><i class="bi bi-person-badge me-1"></i> Referensi Influencer</small>
                    <span class="fw-semibold text-dark">${data.nama}</span>
                </div>
                <div class="text-end">
                    <small class="d-block text-muted fw-bold mb-1">Budget Plan</small>
                    <span class="fw-bold text-success">${formatCurrencyDisplay(data.budget || 0)}</span>
                </div>
            </div>`;

        });

        if (html) {
            $(containerId).html(html).show();
        } else {
            $(containerId).hide();
        }
    }

    function renderPics(picsArr, containerId, size = 32) {
        let html = '';
        if (picsArr && picsArr.length > 0) {
            picsArr.forEach(p => {
                html += `<img src="${p.avatar || p.profile_picture}" class="rounded-circle border border-white me-n2" 
                             width="${size}" height="${size}" title="${p.name || p.full_name}" data-bs-toggle="tooltip" 
                             style="object-fit:cover; background:#fff;">`;
            });
        } else {
            html = '<span class="small text-muted fst-italic ms-1">-</span>';
        }
        $(containerId).html(html);
    }

    function renderPlacement(placementData, containerId) {
        // 1. Konfigurasi Label & Warna (Bootstrap 5 Class)
        const config = {
            '1': {
                label: 'Instagram',
                className: 'bg-danger'
            }, // Merah/Pink (IG style)
            '2': {
                label: 'TikTok',
                className: 'bg-dark'
            }, // Hitam (TikTok style)
            '3': {
                label: 'Influencer',
                className: 'bg-primary'
            }, // Biru
            '4': {
                label: 'Mediagram',
                className: 'bg-success'
            } // Hijau
        };

        let html = '';

        // 2. Cek apakah data ada
        if (placementData) {
            // Normalisasi data: Jika string "1,3,4", ubah jadi array ["1", "3", "4"]
            // Jika sudah array, pakai langsung. Jika single number, bungkus array.
            let ids = [];
            if (Array.isArray(placementData)) {
                ids = placementData;
            } else if (typeof placementData === 'string') {
                ids = placementData.split(','); // Pecah berdasarkan koma
            } else {
                ids = [placementData]; // Jika cuma angka 1
            }

            // 3. Looping Array ID
            ids.forEach(id => {
                let cleanId = id.toString().trim(); // Bersihkan spasi jika ada "1, 3"

                if (config[cleanId]) {
                    let item = config[cleanId];
                    // Tambahkan badge ke variabel html
                    html += `<span class="badge ${item.className} me-1 mb-1 shadow-sm">
                            ${item.label}
                         </span>`;
                }
            });
        }

        // 4. Render ke HTML (Jika kosong, tampilkan strip)
        if (html === '') {
            html = '<span class="text-muted fst-italic">-</span>';
        }

        $(containerId).html(html);
    }

    function renderPriority(priorityData, containerId) {
        const config = {
            '1': {
                label: 'Low',
                className: 'bg-info'
            },
            '2': {
                label: 'Medium',
                className: 'bg-warning'
            },
            '3': {
                label: 'High',
                className: 'bg-danger'
            }
        };

        let html = '';
        if (priorityData) {
            let cleanId = priorityData.toString().trim();

            if (config[cleanId]) {
                let item = config[cleanId];
                html += `<span class="badge ${item.className} d-flex align-items-center gap-1" style="width:max-content"> ${item.label}</span>`
            }
        }

        // 4. Render ke HTML (Jika kosong, tampilkan strip)
        if (html === '') {
            html = '<span class="text-muted fst-italic">-</span>';
        }

        $(containerId).html(html);

    }

    // Alert Standar (Warning/Error)
    const showValidasi = (pesan) => {
        $.alert({
            title: 'Oops!',
            content: pesan,
            type: 'orange',
            icon: 'fa fa-exclamation-triangle',
            buttons: {
                ok: {
                    text: 'OK',
                    btnClass: 'btn-orange'
                }
            }
        });
    };

    // Alert Sukses
    const showSuccess = (pesan) => {
        $.alert({
            title: 'Berhasil!',
            content: pesan,
            type: 'green',
            icon: 'fa fa-check-circle',
            buttons: {
                ok: {
                    text: 'Ok',
                    btnClass: 'btn-green'
                }
            }
        });
    };

    // --- 2. Load Data Table ---

    function loadMasterKol() {
        if ($.fn.DataTable.isDataTable('#tableMasterKol')) {
            $('#tableMasterKol').DataTable().destroy();
        }

        $.getJSON(baseUrl + '/get_all_master_kol', function(res) {
            $('#tableMasterKol').DataTable({
                data: res.data,
                paging: true,
                lengthChange: false,
                pageLength: 5,
                autoWidth: false,
                language: {
                    emptyTable: "Tidak ada data KOL"
                },
                columns: [{
                        data: 'nama'
                    },
                    {
                        data: 'kategory_name'
                    },
                    {
                        data: 'username_ig',
                        render: (data) => data ? `<a href="https://instagram.com/${data}" target="_blank"><i class="fab fa-instagram"></i> ${data}</a>` : '-'
                    },
                    {
                        data: 'username_tt',
                        render: (data) => data ? `<a href="https://tiktok.com/@${data}" target="_blank"><i class="fab fa-tiktok"></i> ${data}</a>` : '-'
                    },
                    {
                        data: 'ratecard',
                        render: (data) => formatCurrencyDisplay(data)
                    },
                    {
                        data: 'last_konten_1_ig',
                        render: (data, type, row) => renderLastKonten(row, 'ig')
                    },
                    {
                        data: 'last_konten_1_tt',
                        render: (data, type, row) => renderLastKonten(row, 'tt')
                    },
                    {
                        data: 'area'
                    },
                    {
                        data: 'nomor_wa'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'niche'
                    },
                    {
                        data: 'id',
                        className: "text-center",
                        render: function(data) {
                            return `<div class="d-flex flex-column justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-warning btnEditKol" data-id="${data}" title="Edit"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger btnDeleteKol" data-id="${data}" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </div>`;
                        }
                    }
                ]
            });
        }).fail(function() {
            console.error("Gagal mengambil data");
        });
    }

    // IG
    $(document).on('input', `
    [name="last_konten_1_ig"],
    [name="last_konten_2_ig"],
    [name="last_konten_3_ig"],
    [name="last_konten_4_ig"],
    [name="last_konten_5_ig"],
    [name="last_rate_card_ig"]
`, function() {
        calculateCPVInput('ig');
    });


    // TikTok
    $(document).on('input', `
    [name="last_konten_1_tt"],
    [name="last_konten_2_tt"],
    [name="last_konten_3_tt"],
    [name="last_konten_4_tt"],
    [name="last_konten_5_tt"],
    [name="last_rate_card_tt"]
`, function() {
        calculateCPVInput('tt');
    });


    function calculateCPVInput(type) {

        let total = 0;
        let count = 0;

        // Ambil last konten 1 - 5
        for (let i = 1; i <= 5; i++) {

            let el = document.querySelector(
                `[name="last_konten_${i}_${type}"]`
            );

            if (!el) continue;

            let val = parseInt(el.value.replace(/\D/g, '')) || 0;

            if (val > 0) {
                total += val;
                count++;
            }
        }

        // Ambil ratecard
        let rateEl = document.querySelector(
            `[name="last_rate_card_${type}"]`
        );

        let rate = 0;

        if (rateEl) {
            rate = parseInt(rateEl.value.replace(/\D/g, '')) || 0;
        }

        // Target input CPV
        let cpvInput = document.getElementById(`cpv_${type}`);

        if (!cpvInput) return;

        // Hitung
        if (count > 0 && rate > 0) {

            let avg = total / count;
            let cpv = Math.round(rate / avg);

            cpvInput.value = formatCurrencyDisplay(cpv);

        } else {

            cpvInput.value = '';
        }
    }


    // Helper render konten views
    function renderLastKonten(row, platform) {
        let html = '';
        let hasData = false;
        for (let i = 1; i <= 5; i++) {
            const key = `last_konten_${i}_${platform}`;
            // Cek jika data ada dan tidak 0/null
            if (row[key] && row[key] != 0) {
                html += `<small class="d-block text-nowrap">#${i}: ${formatNumberDisplay(row[key])}</small>`;
                hasData = true;
            }
        }
        return hasData ? html : '<span class="text-muted">-</span>';
    }

    // --- 3. Event Handlers ---

    // Buka Modal
    $('#btnAddKol').on('click', function() {
        $('#modalAddKol').modal('show');
        loadMasterKol();
    });

    $('#btnAddKol2').on('click', function() {
        $('#modalAddKol').modal('show');
        loadMasterKol();
    });

    // Submit Form dengan Konfirmasi
    $("#formAddKol").on("submit", function(e) {
        e.preventDefault();

        let form = $(this);
        let btn = $("#btnSaveKol");
        let rawData = form.serializeArray();
        let payload = {};

        $.each(rawData, function(i, field) {
            let isNumericField =
                field.name.includes("follower") ||
                field.name.includes("rate_card") ||
                field.name.includes("last_konten") ||
                field.name === "ratecard";

            if (isNumericField) {
                let cleanValue = field.value.replace(/[^0-9]/g, "");
                payload[field.name] = cleanValue === "" ? "0" : cleanValue;
            } else {
                payload[field.name] = field.value;
            }
        });

        // Cek mode update/insert
        const isEdit = !!payload.id && payload.id !== "";
        // console.log('Payload ID:', payload.id);

        $.confirm({
            title: isEdit ? "Konfirmasi Update" : "Konfirmasi Simpan",
            content: isEdit ?
                "Update data KOL ini?" : "Apakah data yang dimasukkan sudah benar?",
            type: "blue",
            buttons: {
                simpan: {
                    text: isEdit ? "Update" : "Simpan",
                    btnClass: "btn-blue",
                    action: function() {
                        btn
                            .prop("disabled", true)
                            .html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                        const url = isEdit ?
                            baseUrl + "/update_master_kol" :
                            baseUrl + "/insert_master_kol";
                        $.post(
                            url,
                            payload,
                            function(res) {
                                btn
                                    .prop("disabled", false)
                                    .html('<i class="fas fa-save"></i> Simpan KOL');
                                if (res.status) {
                                    showSuccess(
                                        isEdit ?
                                        "Data KOL berhasil diupdate!" :
                                        "Data KOL berhasil ditambahkan!"
                                    );
                                    form[0].reset();
                                    $("#kol_id").val("");
                                    loadMasterKol();
                                } else {
                                    showValidasi(res.message || "Gagal menyimpan data.");
                                }
                            },
                            "json"
                        ).fail(function() {
                            btn
                                .prop("disabled", false)
                                .html('<i class="fas fa-save"></i> Simpan KOL');
                            showValidasi("Terjadi kesalahan server.");
                        });
                    },
                },
                batal: function() {},
            },
        });
    });

    // Delete dengan Konfirmasi
    $(document).on('click', '.btnDeleteKol', function() {
        const id = $(this).data('id');

        $.confirm({
            title: 'Hapus Data?',
            content: 'Data yang dihapus tidak dapat dikembalikan.',
            type: 'red',
            icon: 'fa fa-trash',
            buttons: {
                hapus: {
                    text: 'Hapus',
                    btnClass: 'btn-red',
                    action: function() {
                        $.post(baseUrl + '/delete_master_kol', {
                            id: id
                        }, function(res) {
                            if (res.status) {
                                // showSuccess('Data berhasil dihapus'); // Opsional, kadang user ingin cepat
                                loadMasterKol();
                            } else {
                                showValidasi(res.message || 'Gagal menghapus data.');
                            }
                        }, 'json');
                    }
                },
                batal: function() {}
            }
        });
    });

    $(document).on('click', '.btnEditKol', function() {
        const id = $(this).data('id');
        $.getJSON(baseUrl + '/get_master_kol_by_id', {
            id
        }, function(res) {
            if (res.status && res.data) {
                const d = res.data;
                // Isi form modal
                $('#modalAddKol').modal('show');
                $('#formAddKol')[0].reset();
                // Set semua field
                $('#kolPlacement').val(d.kategory).trigger('change');
                $('input[name="nama"]').val(d.nama);
                $('input[name="area"]').val(d.area);
                $('input[name="no_wa"]').val(d.nomor_wa);
                $('input[name="email"]').val(d.email);
                $('input[name="niche"]').val(d.niche);

                // Instagram
                $('input[name="username_ig"]').val(d.username_ig);
                $('input[name="link_ig"]').val(d.link_ig);
                $('input[name="follower_ig"]').val(formatNumberDisplay(d.follower_ig));
                $('input[name="last_rate_card_ig"]').val(formatCurrencyDisplay(d.last_rate_card_ig));
                for (let i = 1; i <= 5; i++) {
                    $(`input[name="last_konten_${i}_ig"]`).val(formatNumberDisplay(d[`last_konten_${i}_ig`]));
                }

                // TikTok
                $('input[name="username_tt"]').val(d.username_tt);
                $('input[name="link_tt"]').val(d.link_tt);
                $('input[name="follower_tt"]').val(formatNumberDisplay(d.follower_tt));
                $('input[name="last_rate_card_tt"]').val(formatCurrencyDisplay(d.last_rate_card_tt));
                for (let i = 1; i <= 5; i++) {
                    $(`input[name="last_konten_${i}_tt"]`).val(formatNumberDisplay(d[`last_konten_${i}_tt`]));
                }

                // Ratecard umum
                $('input[name="ratecard"]').val(formatCurrencyDisplay(d.ratecard));

                // Simpan ID ke hidden input (tambahkan di form jika belum ada)
                $('#master_kol_id').val(d.id);
            } else {
                showValidasi('Gagal mengambil data KOL.');
            }
        });
    });


    function clearElement(id, action = "text", value = null) {
        const $el = $(id);
        if (!$el.length) return;

        switch (action) {
            case "text":
                $el.text(value ?? "-");
                break;

            case "html":
                $el.html(value ?? "-");
                break;

            case "val":
                $el.val(value ?? "");
                break;

            case "empty":
                $el.empty();
                break;

            case "hideEmpty":
                $el.hide().empty();
                break;
        }
    }

    function clearElements(map) {
        map.forEach(item => {
            clearElement(item.id, item.action, item.value);
        });
    }
</script>

<!-- event handle kanban -->
<script>
    $(document).ready(function() {

        let startOfMonth = moment().startOf('month');
        let endOfMonth = moment().endOf('month');


        for (let i = 1; i <= 6; i++) {
            initKanbanDatepicker(i);
        }
        // Set nilai hidden input default
        $('#f_start_date').val(startOfMonth.format('YYYY-MM-DD'));
        $('#f_end_date').val(endOfMonth.format('YYYY-MM-DD'));

        $('#filter_date_campaign').daterangepicker({
            startDate: startOfMonth,
            endDate: endOfMonth,
            locale: {
                format: 'DD MMM YYYY',
                separator: ' - ',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                customRangeLabel: 'Custom'
            },
            ranges: {
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
                'Semua Waktu': [moment().subtract(5, 'year'), moment().add(5, 'year')] // Opsi "All" manual
            }
        }, function(start, end) {
            // Callback saat tanggal dipilih
            $('#f_start_date').val(start.format('YYYY-MM-DD'));
            $('#f_end_date').val(end.format('YYYY-MM-DD'));
        });

        // B. Load List PIC untuk Filter (Untuk Select Option)
        // Kita panggil API get_pic_by_company tapi tanpa ID agar ambil semua (perlu penyesuaian di controller)
        // Atau ambil dari list karyawan global jika ada. 
        // Disini saya buat contoh ambil semua karyawan department marcom
        $.ajax({
            url: baseUrl + "/get_all_marcom_employees", // Kita buat endpoint baru/reuse yg ada
            type: "GET",
            dataType: "json",
            success: function(res) {
                let html = '<option value="">Semua PIC</option>';
                res.forEach(p => {
                    html += `<option value="${p.user_id}">${p.full_name} | ${p.designation_name}</option>`;
                });
                $('#filter_pic').html(html);

                new SlimSelect({
                    select: '#filter_pic'
                })
            }
        });

        // C. Load Data Awal
        loadCampaignList();
    });

    // --- 2. EVENT LISTENER BUTTON FILTER & SEARCH ---
    $('#btnFilterCampaign').click(function() {
        loadCampaignList();
    });

    // Search on Enter Key
    $('#search_campaign').keypress(function(e) {
        if (e.which == 13) {
            loadCampaignList();
        }
    });

    function loadKanbanData(tab_id = 1) {
        // Ambil filter spesifik tab tersebut
        let startDate = $(`#f_start_date_${tab_id}`).val();
        let endDate = $(`#f_end_date_${tab_id}`).val();
        let keyword = $(`#search_${tab_id}`).val();

        // console.log(tab_id)

        $.ajax({
            url: "<?= base_url('marcom/get_campaigns'); ?>",
            type: "POST", // Ganti ke POST untuk kirim filter
            dataType: "json",
            data: {
                start_date: startDate,
                end_date: endDate,
                keyword: keyword,
                status: tab_id
            },
            success: function(res) {
                if (res.status) {
                    kanbanData = res.data;
                    renderKanban(tab_id);
                    initDragula(tab_id);
                }
            },
            error: function(err) {
                console.error("Gagal memuat campaign", err);
            }
        });
    }

    function renderKanban(tab_id) {
        $(`#pending_${tab_id}`).empty();
        $(`#progress_${tab_id}`).empty();
        $(`#review_${tab_id}`).empty();
        $(`#done_${tab_id}`).empty();

        let count_pending = 0;
        let count_progress = 0;
        let count_review = 0;
        let count_done = 0;

        let baseId = (tab_id - 1) * 4;

        kanbanData
            .filter(item => parseInt(item.status) >= tab_id)
            .forEach(item => {

                // --- 1. TENTUKAN PIC BERDASARKAN TAB ---
                let activePicsData = [];

                if (tab_id == 1) {
                    activePicsData = (item.pics_riset && item.pics_riset.length > 0) ? item.pics_riset : item.pics_main;
                } else if (tab_id == 2) {
                    activePicsData = (item.pics_script && item.pics_script.length > 0) ? item.pics_script : [];
                } else if (tab_id == 3) {
                    activePicsData = (item.pics_kol && item.pics_kol.length > 0) ? item.pics_kol : [];
                } else if (tab_id == 4) {
                    activePicsData = (item.pics_budget && item.pics_budget.length > 0) ? item.pics_budget : [];
                } else if (tab_id == 5) {
                    activePicsData = (item.pics_shooting && item.pics_shooting.length > 0) ? item.pics_shooting : [];
                } else if (tab_id == 6) {
                    activePicsData = (item.pics_editing && item.pics_editing.length > 0) ? item.pics_editing : [];
                } else {
                    activePicsData = item.pics_main;
                }

                // --- 2. RENDER PIC ---
                let pics_html = "";
                if (activePicsData && activePicsData.length > 0) {
                    const maxShow = 2;
                    activePicsData.slice(0, maxShow).forEach(p => {
                        pics_html += `<img src="${p.profile_picture}" class="pic-avatar me-n1" title="${p.full_name}" data-bs-toggle="tooltip">`;
                    });
                    if (activePicsData.length > maxShow) {
                        const more = activePicsData.length - maxShow;
                        const listName = activePicsData.slice(maxShow).map(p => p.full_name).join(', ');
                        pics_html += `<span class="avatar-more" title="${listName}">+${more}</span>`;
                    }
                } else {
                    pics_html = `<span class="small text-muted fst-italic" style="font-size:10px;">Belum ada PIC</span>`;
                }

                let priorityClass = item.priority == 3 ? "badge-high" : item.priority == 2 ? "badge-medium" : "badge-low";
                let priorityText = item.priority == 3 ? "High" : item.priority == 2 ? "Medium" : "Low";

                // **TAMBAHKAN DATA PICS UNTUK PERMISSION CHECK**
                let picIds = activePicsData.map(p => p.user_id).join(',');

                let card = `
                <div class="kanban-card" data-id="${item.id}" data-company_id="${item.company_id}" data-pic-ids="${picIds}">
                    <div class="d-flex flex-column mb-1">
                        <span class="badge-event">${item.campaign_name || '-'}</span>
                        <span class="fw-semibold mt-1" style="font-size:0.8rem;">#${item.id || '-'}</span>
                    </div>
                    <h6 class="fw-semibold mt-4" style="font-size:0.8rem;">${item.goals}</h6>
                    <div class="small text-muted kanban-desc">${item.description || '-'}</div>

                    <div class="d-flex align-items-center justify-content-between gap-2 m-2">
                        <span class="small text-muted">PIC :</span>
                        <div class="d-flex align-items-center">
                            ${pics_html}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted"><i class="bi bi-calendar"></i> ${item.start_date || ''}</span>
                        <span class="badge badge-priority ${priorityClass}"><i class="bi bi-flag-fill"></i> ${priorityText}</span>
                    </div>
                </div>`;

                let currentStatus = parseInt(item.status);
                let p = parseInt(item.status_progres);

                if (currentStatus > tab_id) {
                    $(`#done_${tab_id}`).append(card);
                    count_done++;
                } else if (currentStatus == tab_id) {
                    if (p === baseId + 1) {
                        $(`#pending_${tab_id}`).append(card);
                        count_pending++;
                    } else if (p === baseId + 2) {
                        $(`#progress_${tab_id}`).append(card);
                        count_progress++;
                    } else if (p === baseId + 3) {
                        $(`#review_${tab_id}`).append(card);
                        count_review++;
                    } else if (p === baseId + 4) {
                        $(`#done_${tab_id}`).append(card);
                        count_done++;
                    }
                }
            });

        $(`#count_pending_${tab_id}`).text(count_pending);
        $(`#count_progress_${tab_id}`).text(count_progress);
        $(`#count_review_${tab_id}`).text(count_review);
        $(`#count_done_${tab_id}`).text(count_done);
    }

    let dragulaInstance;

    // ...

    // 2. Perbaiki fungsi initDragula
    function initDragula(tab_id) {
        // PENTING: Hancurkan instance lama jika ada agar event tidak double
        if (dragulaInstance) {
            dragulaInstance.destroy();
        }

        // Simpan instance baru ke variabel global
        dragulaInstance = dragula([
            document.getElementById(`pending_${tab_id}`),
            document.getElementById(`progress_${tab_id}`),
            document.getElementById(`review_${tab_id}`),
            document.getElementById(`done_${tab_id}`)
        ]).on("drop", function(el, target, source) {
            updateProgress(el, target, tab_id, source);
        });
    }


    // ===============================
    // 🔁 HANDLE PINDAH TAB
    // ===============================
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        // Menggunakan getAttribute agar lebih konsisten dengan Bootstrap 5
        const target = e.target.getAttribute('data-bs-target');

        if (target === '#tabCampaign') {
            loadCampaignList();
        } else {
            // Ambil ID tab (misal: "#tab1" menjadi 1)
            const tab_id = parseInt(target.replace('#tab', ''), 10);

            // PERBAIKAN: Gunakan loadKanbanData()
            // Agar mengambil data terbaru dari server via AJAX.
            // Fungsi ini otomatis memanggil renderKanban() dan initDragula() setelah data didapat.
            loadKanbanData(tab_id);
        }
    });

    function updateProgressBackend(id, status, status_progres, oldStatusProgres) {
        $.ajax({
            url: "<?= base_url('marcom/update_progress'); ?>",
            type: "POST",
            data: {
                id: id,
                status: status,
                status_progres: status_progres,
                oldStatusProgres: oldStatusProgres
            },
            dataType: "json", // Pastikan tipe data JSON agar parsing otomatis
            success: function(res) {
                // Jika Backend Menolak (Validasi Gagal)
                if (res.status === false) {

                    // 1. Tutup paksa modal jika terlanjur terbuka
                    $(".modal").modal("hide");

                    // 2. Tampilkan Pesan Error
                    $.alert({
                        title: 'Data Belum Lengkap',
                        content: res.message,
                        type: 'orange',
                        icon: 'fa fa-exclamation-circle',
                        buttons: {
                            ok: {
                                text: 'OK, Lengkapi Data',
                                btnClass: 'btn-orange',
                                action: function() {
                                    // 3. Kembalikan kartu ke posisi asal (Reload Kanban)
                                    loadKanbanData(status);
                                }
                            }
                        }
                    });
                } else {
                    // Jika sukses, tidak perlu aksi visual khusus (biarkan dragula/modal logic jalan)
                    // console.log("Update sukses");
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal update ke backend", xhr.responseText);
                // Revert jika error server
                loadKanbanData(status);
            }
        });
    }

    function sendNotifReject(id, status) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('marcom/sendNotifReject'); ?>",
            data: {
                campaign_id: id,
                status: status
            },
            dataType: "json",
            success: function(response) {
                console.log(response)
            }
        });
    }

    function sendNotifApprove(id, status) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('marcom/sendNotifApprove'); ?>",
            data: {
                campaign_id: id,
                status: status
            },
            dataType: "json",
            success: function(response) {
                console.log(response)
            }
        });
    }

    function updateProgress(el, target, tab_id, source) {
        let id = $(el).data("id");

        // --- VALIDASI 1: TASK COMPLETED TIDAK BISA KEMBALI ---
        // Cek jika kolom asal adalah 'done' (Completed)
        if (source.id.includes("done")) {
            $.alert({
                title: 'Akses Ditolak',
                content: 'Task yang sudah <b>Completed</b> tidak dapat dipindahkan kembali!',
                type: 'red',
                icon: 'fa fa-ban',
                buttons: {
                    ok: {
                        action: function() {
                            loadKanbanData(tab_id); // Revert posisi kartu
                        }
                    }
                }
            });
            return;
        }

        // --- VALIDASI 2: DILARANG DRAG KE COMPLETED (DARI MANAPUN) ---
        // Mencegah Pending -> Done, Progress -> Done, dan Review -> Done
        if (target.id.includes("done")) {
            $.alert({
                title: 'Aksi Tidak Diizinkan',
                content: 'Anda tidak dapat menggeser kartu ke <b>Completed</b> secara manual.<br><br>Untuk menyelesaikan task!',
                type: 'orange',
                icon: 'fa fa-exclamation-triangle',
                buttons: {
                    ok: {
                        action: function() {
                            loadKanbanData(tab_id); // Mengembalikan kartu ke posisi semula
                        }
                    }
                }
            });
            return;
        }

        // --- PROSES PERPINDAHAN NORMAL (Pending <-> Progress <-> Review) ---

        let baseStatus = (tab_id - 1) * 4;

        let oldColumnIndex = source.id.includes("pending") ? 1 :
            source.id.includes("progress") ? 2 :
            source.id.includes("review") ? 3 : 4;
        let oldStatusProgres = baseStatus + oldColumnIndex;

        let newColumnIndex = target.id.includes("pending") ? 1 :
            target.id.includes("progress") ? 2 :
            target.id.includes("review") ? 3 : 4;
        let newStatusProgres = baseStatus + newColumnIndex;

        // Update ke Backend
        updateProgressBackend(id, tab_id, newStatusProgres, oldStatusProgres);

        // --- LOGIC TRIGGER MODAL (AUTO OPEN SAAT DRAG) ---

        // TAB 1: Riset SPV
        if (tab_id == 1 && (newStatusProgres == 2 || newStatusProgres == 3)) { // InProg atau Review
            $.post(baseUrl + "/create_riset_spv_if_not_exist", {
                campaign_id: id
            }, function(res) {
                $("#modalRisetSPV").modal("show");
                loadRisetDetail(id);
            }, "json");
        }

        // TAB 2: Content Script
        if (tab_id == 2 && (newStatusProgres == 6 || newStatusProgres == 7)) { // InProg atau Review
            $("#modalContentScript").modal("show");
            loadScriptDetail(id);
        }

        // TAB 3: Riset KOL
        if (tab_id == 3 && (newStatusProgres == 10 || newStatusProgres == 11)) { // InProg atau Review
            $.post(baseUrl + "/create_riset_kol_if_not_exist", {
                campaign_id: id
            }, function(res) {
                $("#modalRisetKOL").modal("show");
                loadRisetKOLDetail(id);
            }, "json");
        }

        // TAB 4: Budgeting
        if (tab_id == 4 && (newStatusProgres == 14 || newStatusProgres == 15)) { // InProg atau Review
            showLoader({
                text: 'Menyiapkan Form Budgeting...'
            });

            $.post(baseUrl + "/create_budgeting_if_not_exist", {
                campaign_id: id
            }, function() {
                loadBudgetingDetail(id, function() {

                    // Kode ini hanya jalan setelah semua Ajax & Render selesai
                    hideLoader(); // Hapus loader
                    $("#modalBudgeting").modal("show"); // Baru buka modal

                });
            });
        }

        if (tab_id == 5 && (newStatusProgres == 18 || newStatusProgres == 19)) { // InProg atau Review
            $("#modalShooting").modal("show");
            loadShootingDetail(id);
        }

        if (tab_id == 6 && (newStatusProgres == 22 || newStatusProgres == 23)) { // InProg atau Review
            $("#modalEditing").modal("show");
            loadEditingDetail(id);
        }
    }


    // --- 3. UPDATE FUNGSI LOAD CAMPAIGN LIST ---
    function loadCampaignList() {
        // Ambil nilai dari filter
        let startDate = $('#f_start_date').val();
        let endDate = $('#f_end_date').val();
        let companyId = $('#filter_company').val();
        let picId = $('#filter_pic').val();
        let keyword = $('#search_campaign').val();

        $.ajax({
            url: "<?= base_url('marcom/get_campaign_list'); ?>",
            type: "POST", // Ubah jadi POST agar lebih rapi kirim param banyak
            dataType: "json",
            data: {
                start_date: startDate,
                end_date: endDate,
                company_id: companyId,
                pic_id: picId,
                keyword: keyword
            },
            beforeSend: function() {
                $("#campaignList").html('<div class="col-12 text-center p-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Memuat data...</p></div>');
            },
            success: function(res) {
                if (!res.status) {
                    $("#campaignList").html('<div class="col-12 text-center text-danger p-4">Gagal memuat data.</div>');
                    return;
                }

                const list = res.data || [];
                const container = $("#campaignList");
                container.empty();

                // Update info total
                $("#total_campaign_show").text(`Menampilkan ${list.length} Campaign`);

                if (list.length === 0) {
                    container.html(`
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mt-3">Tidak ada campaign ditemukan pada periode/filter ini.</p>
                    </div>
                `);
                    return;
                }

                const getPriorityBadge = (priorityVal) => {
                    let badgeClass = 'badge-low'; // Default
                    let badgeText = 'Low';

                    if (priorityVal == 2) {
                        badgeClass = 'badge-medium';
                        badgeText = 'Medium';
                    } else if (priorityVal == 3) {
                        badgeClass = 'badge-high';
                        badgeText = 'High';
                    }

                    return `<span class="priority-badge ${badgeClass}"> ${badgeText}</span>`;
                };

                // 2. Loop Render Card
                list.forEach(item => {
                    // Handle PIC avatars
                    let pics_html = "";
                    if (item.pics_riset && item.pics_riset.length > 0) {
                        const maxShow = 2;
                        item.pics_riset.slice(0, maxShow).forEach(p => {
                            pics_html += `<img src="${p.profile_picture}" class="pic-avatar me-n1">`;
                        });

                        if (item.pics_riset.length > maxShow) {
                            const more = item.pics_riset.length - maxShow;
                            pics_html += `<span class="avatar-more ms-1">+${more}</span>`;
                        }
                    } else {
                        pics_html = `<span class="small text-muted">-</span>`;
                    }

                    const progress = item.progress_percent || 0;
                    const docs = item.docs_count || 0;
                    const links = item.links_count || 0;
                    const eventLabel = item.campaign_name || 'Campaign';

                    // Gunakan Helper Function untuk Priority
                    const priorityBadgeHtml = getPriorityBadge(item.priority);
                    const campaignCodeHtml = item.id ? `<span class="small text-muted">${item.id}</span>` : '';

                    const card = `
                <div class="card campaign-card mb-3" data-id="${item.id}" style="cursor:pointer;">
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2 gap-3">
                            <span class="event-label">${eventLabel}</span>
                            ${campaignCodeHtml}
                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-6 small label-gray">
                                <i class="bi bi-flag"></i> Prioritas
                            </div>
                            <div class="col-6 text-end">
                                ${priorityBadgeHtml}
                            </div>
                        </div>

                         <div class="row align-items-center mb-2">
                            <div class="col-6 small label-gray">
                                <i class="bi bi-building"></i> Company
                            </div>
                            <div class="col-6 text-end" style="font-size: smaller;">
                                ${item.company_name}
                            </div>
                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-4 small label-gray">
                                <i class="bi bi-calendar"></i> Timeline
                            </div>
                            <div class="col-8 small text-end timeline-date">
                                ${item.start_date || '-'} ➜ ${item.end_date || '-'}
                            </div>
                        </div>


                        <div class="row align-items-center mb-2">
                            <div class="col-6 small label-gray">
                                <i class="bi bi-people"></i> PIC
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-end">
                                    ${pics_html}
                                </div>
                            </div>
                        </div>

                        <div class="small label-gray mb-1">Progress</div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="progress custom-progress">
                                <div class="progress-bar" role="progressbar" style="width:${progress}%"></div>
                            </div>
                            <div class="small label-gray">${progress}%</div>
                        </div>

                        <div class="small label-gray mb-1">Deskripsi Campaign</div>
                        <div class="desc-box p-2 mb-3">
                            <p class="desc-text">${item.description || '-'}</p>
                        </div>

                        <div class="d-flex gap-3 small text-muted border-top pt-2">
                            <span><i class="bi bi-file-earmark"></i> ${docs} Lampiran File</span>
                            <span><i class="bi bi-link-45deg"></i> ${links} Lampiran Link</span>
                        </div>

                    </div>
                </div>`;

                    container.append(card);
                });
            },
            error: function(xhr) {
                $("#campaignList").html('<div class="text-danger">Error server.</div>');
            }
        });
    }


    function initKanbanDatepicker(id) {
        let startOfMonth = moment().startOf('month');
        let endOfMonth = moment().endOf('month');

        // Set default value
        $(`#f_start_date_${id}`).val(startOfMonth.format('YYYY-MM-DD'));
        $(`#f_end_date_${id}`).val(endOfMonth.format('YYYY-MM-DD'));
        $(`#filter_date_${id}`).val(startOfMonth.format('DD/MM/YYYY') + ' - ' + endOfMonth.format('DD/MM/YYYY'));

        $(`#filter_date_${id}`).daterangepicker({
            startDate: startOfMonth,
            endDate: endOfMonth,
            autoUpdateInput: false, // Supaya bisa kosong jika di-reset
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'Pilih',
                cancelLabel: 'Clear',
                customRangeLabel: 'Custom'
            },
            ranges: {
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
                'Semua': [moment().subtract(2, 'year'), moment().add(2, 'year')]
            }
        }, function(start, end) {
            $(`#f_start_date_${id}`).val(start.format('YYYY-MM-DD'));
            $(`#f_end_date_${id}`).val(end.format('YYYY-MM-DD'));
            $(`#filter_date_${id}`).val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        });

        // Handle tombol Cancel/Clear di datepicker
        $(`#filter_date_${id}`).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $(`#f_start_date_${id}`).val('');
            $(`#f_end_date_${id}`).val('');
        });
    }

    $(document).on('click', '.btn-filter-kanban', function() {
        let tabId = $(this).data('tab');
        loadKanbanData(tabId);
    });

    // Handle Reset
    $(document).on('click', '.btn-reset-kanban', function() {
        let tabId = $(this).data('tab');
        // Reset Inputs
        $(`#search_${tabId}`).val('');
        initKanbanDatepicker(tabId); // Re-init date to default
        loadKanbanData(tabId);
    });

    // Handle Enter di Search
    for (let i = 1; i <= 4; i++) {
        $(`#search_${i}`).keypress(function(e) {
            if (e.which == 13) loadKanbanData(i);
        });
    }

    // --- EVENT LISTENER KLIK KANBAN CARD ---
    $(document).on("click", ".kanban-card", function() {
        const id = $(this).data("id");
        const company_id = $(this).data("company_id");
        const activeTabPane = $("#taskTabContent .tab-pane.show.active");
        const currentTabId = activeTabPane.attr('id');
        const parentColumnId = $(this).parent().attr('id');

        // **CEK PERMISSION PIC**
        const isPicForCurrentPhase = checkPICPermission(this);

        // Jika bukan PIC dan bukan approver, block akses
        if (!isPicForCurrentPhase && !canApproveAction()) {
            $.alert({
                title: 'Akses Terbatas',
                content: 'Anda bukan PIC untuk fase ini.<br><small class="text-muted">PIC yang ditunjuk dapat mengakses task ini.</small>',
                type: 'orange',
                icon: 'fa fa-lock',
                buttons: {
                    ok: {
                        text: 'Mengerti',
                        btnClass: 'btn-orange'
                    }
                }
            });
            return;
        }


        // ============================================
        // 1. LOGIKA TAB RISET SPV (TAB 1)
        // ============================================
        if (currentTabId === 'tab1') {

            // A. Klik di Kolom Pending (Start/Edit) -> FITUR BARU
            if (parentColumnId === 'pending_1') {
                currentCampaignID = id;
                // Create row jika belum ada (sama seperti logic drag)
                $.post(baseUrl + "/create_riset_spv_if_not_exist", {
                    campaign_id: id
                }, function(res) {
                    $("#modalRisetSPV").modal("show");
                    loadRisetDetail(id);
                }, "json");
            }

            // B. Klik di Kolom In Progress (Edit)
            else if (parentColumnId === 'progress_1') {
                currentCampaignID = id;
                loadRisetDetail(id);
                $("#modalRisetSPV").modal("show");
            }

            // C. Klik di Kolom Review (Approval)
            else if (parentColumnId === 'review_1') {
                if (!canApproveAction()) {
                    $.alert({
                        title: 'Akses Dibatasi',
                        content: 'Anda tidak memiliki hak akses Review.',
                        type: 'red',
                        icon: 'fa fa-ban'
                    });
                    return;
                }
                loadReviewRiset(id);
                $("#modalReviewRiset").modal("show");
                initSlimSelectReview('#picSelectReviewSpv', company_id, 'modalReviewRiset');

                // Mode: EDITABLE
                $("#modalReviewRiset .modal-title").text("Review Riset SPV");
                $("#btnApproveRiset, #btnRejectRiset").show();
                $("#picSelectReviewSpv").closest('.col-md-6').show();
                $("#approve_note").prop('disabled', false);
                $("#deadline_naskah").closest('.col-md-6').show();
            }

            // D. Klik di Kolom Completed (Read Only)
            else if (parentColumnId === 'done_1') {
                loadReviewRiset(id);
                $("#modalReviewRiset").modal("show");
                // Mode: READ ONLY
                $("#modalReviewRiset .modal-title").text("Detail Riset (Selesai)");
                $("#btnApproveRiset, #btnRejectRiset").hide();
                $("#picSelectReviewSpv").closest('.col-md-6').hide();
                $("#approve_note").prop('disabled', true);
                $("#deadline_naskah").closest('.col-md-6').hide();
            }
        }

        // ============================================
        // 2. LOGIKA TAB CONTENT SCRIPT (TAB 2)
        // ============================================
        if (currentTabId === 'tab2') {

            // A. Klik di Kolom Pending (Start/Edit) -> FITUR BARU
            if (parentColumnId === 'pending_2') {
                currentCampaignID = id;
                // Langsung buka modal (sesuai logic updateProgress Tab 2 Anda)
                $("#modalContentScript").modal("show");
                loadScriptDetail(id);
            }

            // B. Klik di Kolom In Progress (Edit)
            else if (parentColumnId === 'progress_2') {
                currentCampaignID = id;
                loadScriptDetail(id);
                $("#modalContentScript").modal("show");
            }

            // C. Klik di Kolom Review (Approval)
            else if (parentColumnId === 'review_2') {
                if (!canApproveAction()) {
                    $.alert({
                        title: 'Akses Dibatasi',
                        content: 'Anda tidak memiliki hak akses Review.',
                        type: 'red',
                        icon: 'fa fa-ban'
                    });
                    return;
                }
                loadReviewScript(id);
                $("#modalReviewScript").modal("show");
                initSlimSelectReview('#picSelectReviewScript', company_id, 'modalReviewScript');

                // Mode: EDITABLE
                $("#modalReviewScript .modal-title").text("Review Content Script");
                $("#btnApproveScript, #btnRejectScript").show();
                $("#picSelectReviewScript").closest('.col-md-6').show();
                $("#approve_script_note").prop('disabled', false);
                $(".naskah-radio").prop('disabled', false);
                $("#deadline_kol").closest('.col-md-6').show();
            }

            // D. Klik di Kolom Completed (Read Only)
            else if (parentColumnId === 'done_2') {
                loadReviewScript(id, true);
                $("#modalReviewScript").modal("show");
                // Mode: READ ONLY
                $("#modalReviewScript .modal-title").text("Detail Script (Selesai)");
                $("#btnApproveScript, #btnRejectScript").hide();
                $("#picSelectReviewScript").closest('.col-md-6').hide();
                $("#deadline_kol").closest('.col-md-6').hide();
                $("#approve_script_note").prop('disabled', true);
            }
        }

        // ============================================
        // 3. LOGIKA TAB RISET KOL (TAB 3)
        // ============================================
        if (currentTabId === 'tab3') {

            // A. Klik di Kolom Pending (Start/Edit) -> FITUR BARU
            if (parentColumnId === 'pending_3') {
                $.post(baseUrl + "/create_riset_kol_if_not_exist", {
                    campaign_id: id
                }, function(res) {
                    $("#modalRisetKOL").modal("show");
                    loadRisetKOLDetail(id);
                }, "json");
            }

            // B. Klik di Kolom In Progress (Edit)
            else if (parentColumnId === 'progress_3') {
                loadRisetKOLDetail(id);
                $("#modalRisetKOL").modal("show");
            }

            // C. Klik di Kolom Review (Approval)
            else if (parentColumnId === 'review_3') {
                if (!canApproveAction()) {
                    $.alert({
                        title: 'Akses Dibatasi',
                        content: 'Anda tidak memiliki hak akses Review.',
                        type: 'red',
                        icon: 'fa fa-ban'
                    });
                    return;
                }
                loadReviewRisetKOL(id);
                $("#modalReviewRisetKOL").modal("show");
                initSlimSelectReview('#picSelectReviewKOL', company_id, 'modalReviewRisetKOL');

                // Mode: Editable
                $("#modalReviewRisetKOL .modal-title").text("Review Riset KOL");
                $("#btnApproveRisetKOL, #btnRejectRisetKOL").show();
                $("#picSelectReviewKOL").closest('.col-md-6').show();
                $("#deadline_budgeting").closest('.col-md-6').show();
                $("#approve_kol_note").prop('disabled', false);
            }

            // D. Klik di Kolom Completed (Read Only)
            else if (parentColumnId === 'done_3') {
                loadReviewRisetKOL(id);
                $("#modalReviewRisetKOL").modal("show");
                // Mode: Read Only
                $("#modalReviewRisetKOL .modal-title").text("Detail Riset KOL (Selesai)");
                $("#btnApproveRisetKOL, #btnRejectRisetKOL").hide();
                $("#picSelectReviewKOL").closest('.col-md-6').hide();
                $("#deadline_budgeting").closest('.col-md-6').hide();
                $("#approve_kol_note").prop('disabled', true);
            }
        }

        // ============================================
        // 4. LOGIKA TAB BUDGETING (TAB 4)
        // ============================================
        if (currentTabId === 'tab4') {

            // A. Klik di Kolom Pending (Start/Edit) -> FITUR BARU
            if (parentColumnId === 'pending_4') {
                $.post(baseUrl + "/create_budgeting_if_not_exist", {
                    campaign_id: id
                }, function() {
                    $("#modalBudgeting").modal("show");
                    loadBudgetingDetail(id);
                }, "json");
            }

            // B. Klik di Kolom In Progress (Edit Inputan)
            else if (parentColumnId === 'progress_4') {
                showLoader({
                    text: 'Menyiapkan Form Budgeting...'
                });
                loadBudgetingDetail(id, function() {

                    // Kode ini hanya jalan setelah semua Ajax & Render selesai
                    hideLoader(); // Hapus loader
                    $("#modalBudgeting").modal("show"); // Baru buka modal

                });
            }

            // C. Klik di Kolom Review (Approval)
            else if (parentColumnId === 'review_4') {
                if (!canApproveAction()) {
                    $.alert({
                        title: 'Akses Dibatasi',
                        content: 'Anda tidak memiliki hak akses untuk Review Budgeting.',
                        type: 'red',
                        icon: 'fa fa-ban'
                    });
                    return;
                }
                loadReviewBudget(id);
                $("#modalReviewBudget").modal("show");
                initSlimSelectReview('#picSelectReviewBudget', company_id, 'modalReviewBudget');

                // Mode Editable
                $("#modalReviewBudget .modal-title").text("Review Budgeting");
                $("#btnApproveBudget, #btnRejectBudget").show();
                $("#picSelectReviewBudget").closest('.col-md-6').show();
                $("#deadline_shooting").closest('.col-md-6').show();
                $("#approve_budget_note").prop('disabled', false);
            }

            // D. Klik di Kolom Completed (Read Only)
            else if (parentColumnId === 'done_4') {
                loadReviewBudget(id);
                $("#modalReviewBudget").modal("show");
                // Mode Read Only
                $("#modalReviewBudget .modal-title").text("Detail Budgeting (Selesai)");
                $("#btnApproveBudget, #btnRejectBudget").hide();
                $("#picSelectReviewBudget").closest('.col-md-6').hide();
                $("#deadline_shooting").closest('.col-md-6').hide();
                $("#approve_budget_note").prop('disabled', true);

            }
        }

        // tab shooting
        if (currentTabId === 'tab5') {
            if (parentColumnId === 'pending_5') {
                $("#modalShooting").modal("show");
                loadShootingDetail(id);
            } else if (parentColumnId === 'progress_5') {
                loadShootingDetail(id);
                $("#modalShooting").modal("show");
            }

            // C. Klik di Kolom Review (Approval)
            else if (parentColumnId === 'review_5') {
                if (!canApproveAction()) {
                    $.alert({
                        title: 'Akses Dibatasi',
                        content: 'Anda tidak memiliki hak akses Review.',
                        type: 'red',
                        icon: 'fa fa-ban'
                    });
                    return;
                }

                // Panggil function load khusus Shooting
                loadReviewShooting(id);
                $("#modalReviewShooting").modal("show");

                // Mode: Editable (Approval)
                $("#modalReviewShooting .modal-title").html('<i class="bi bi-check-circle-fill text-primary me-2"></i>Review Shooting & Assign Editing');

                // Tampilkan Tombol Action
                $("#btnApproveShooting, #btnRejectShooting").show();

                // Enable Form Note
                $("#rv_shooting_note_approve").prop('disabled', false);

                // Tampilkan Form Assign Next (PIC & Deadline Editing)
                $("#rv_shooting_pic_next").closest('.col-md-6').show();
                $("#rv_shooting_deadline_next").closest('.col-md-6').show();
            }

            // D. Klik di Kolom Completed (Read Only Mode)
            else if (parentColumnId === 'done_5') {
                loadReviewShooting(id);
                $("#modalReviewShooting").modal("show");

                // Mode: Read Only (History)
                $("#modalReviewShooting .modal-title").html('<i class="bi bi-info-circle-fill text-success me-2"></i>Detail Shooting (Selesai)');

                // Sembunyikan Tombol Action
                $("#btnApproveShooting, #btnRejectShooting").hide();

                // Disable Form Note (Hanya untuk baca)
                $("#rv_shooting_note_approve").prop('disabled', true);

                // Sembunyikan Form Assign Next karena sudah lewat
                $("#rv_shooting_pic_next").closest('.col-md-6').hide();
                $("#rv_shooting_deadline_next").closest('.col-md-6').hide();
            }
        }

        // tab editing
        if (currentTabId === 'tab6') {
            if (parentColumnId === 'pending_6') {
                $("#modalEditing").modal("show");
                loadEditingDetail(id);
            } else if (parentColumnId === 'progress_6') {
                loadEditingDetail(id);
                $("#modalEditing").modal("show");
            }

            // C. Klik di Kolom Review (Approval)
            else if (parentColumnId === 'review_6') {
                if (!canApproveAction()) {
                    $.alert({
                        title: 'Akses Dibatasi',
                        content: 'Anda tidak memiliki hak akses Review.',
                        type: 'red',
                        icon: 'fa fa-ban'
                    });
                    return;
                }

                // Panggil function load khusus Editing
                loadReviewEditing(id);
                $("#modalReviewEditing").modal("show");

                // Mode: Editable (Approval)
                $("#modalReviewEditing .modal-title").html('<i class="bi bi-check-circle-fill text-primary me-2"></i>Review Editing');

                // Tampilkan Tombol Action
                $("#btnApproveEditing, #btnRejectEditing").show();

                // Enable Form Note
                $("#rv_editing_note_approve").prop('disabled', false);

                $("#rv_editing_pic_next").closest('.col-md-6').show();
                $("#rv_editing_deadline_next").closest('.col-md-6').show();
            }

            // D. Klik di Kolom Completed (Read Only Mode)
            else if (parentColumnId === 'done_6') {
                loadReviewEditing(id);
                $("#modalReviewEditing").modal("show");

                // Mode: Read Only (History)
                $("#modalReviewEditing .modal-title").html('<i class="bi bi-info-circle-fill text-success me-2"></i>Detail Editing (Selesai)');

                // Sembunyikan Tombol Action
                $("#btnApproveEditing, #btnRejectEditing").hide();

                // Disable Form Note (Hanya untuk baca)
                $("#rv_editing_note_approve").prop('disabled', true);

                $("#rv_editing_pic_next").closest('.col-md-6').hide();
                $("#rv_editing_deadline_next").closest('.col-md-6').hide();
            }
        }

    });


    // --- EVENT LISTENER: KLIK CAMPAIGN CARD (TAB 1) ---
    $(document).on("click", ".campaign-card", function() {
        const id = $(this).data("id");
        if (!id) return;

        loadFullDetail(id);
        $("#modalFullDetailCampaign").modal("show");
    });

    // Helper: Cek apakah user adalah PIC fase ini
    function checkPICPermission(cardElement) {
        const picIdsStr = $(cardElement).data('pic-ids');

        // Jika tidak ada PIC (belum assign), return true (allow access)
        if (!picIdsStr || picIdsStr === '') {
            return true;
        }

        // Convert string "1,2,3" ke array
        const picIds = picIdsStr.toString().split(',').map(id => parseInt(id.trim()));

        // Cek apakah userId ada dalam list
        return picIds.includes(userId);
    }


    // --- FUNGSI LOAD FULL DETAIL ---
    function loadFullDetail(campaign_id) {
        // 1. Reset UI Standard
        clearElements([
            // text "-"
            {
                id: "#fd_campaign_name",
                action: "text"
            },
            {
                id: "#fd_timeline",
                action: "text"
            },
            {
                id: "#fd_goals",
                action: "text"
            },
            {
                id: "#fd_big_idea",
                action: "text"
            },
            {
                id: "#fd_campaign_id",
                action: "text"
            },
            {
                id: "#fd_riset_note",
                action: "text"
            },
            {
                id: "#fd_script_note",
                action: "text"
            },
            {
                id: "#fd_kol_note",
                action: "text"
            },

            // html "-"
            {
                id: "#fd_description",
                action: "html"
            },
            {
                id: "#fd_riset_report",
                action: "html"
            },
            {
                id: "#fd_trend_analysis",
                action: "html"
            },
            {
                id: "#fd_naskah_final",
                action: "html"
            },
            {
                id: "#fd_riset_pic",
                action: "html"
            },
            {
                id: "#fd_script_pic",
                action: "html"
            },
            {
                id: "#fd_kol_pic",
                action: "html"
            },

            // empty
            {
                id: "#fd_kol_container",
                action: "empty"
            },
            {
                id: "#fd_brief_file_container",
                action: "empty"
            },
            {
                id: "#fd_brief_link_container",
                action: "empty"
            },
            {
                id: "#fd_priority",
                action: "empty"
            },
            {
                id: "#fd_riset_links",
                action: "empty"
            },
            {
                id: "#fd_riset_files",
                action: "empty"
            },
            {
                id: "#fd_kol_files",
                action: "empty"
            },

            // special value
            {
                id: "#fd_total_budget",
                action: "text",
                value: "Rp 0"
            }
        ]);

        // UI state (bukan clear → tetap jQuery)
        $("#fd_brief_influencer_row").hide();


        // Reset Accordion State
        $('.accordion-collapse').removeClass('show');
        $('#collapseBrief').addClass('show');


        $.ajax({
            url: baseUrl + "/get_full_campaign_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    const d = res.data;

                    // --- HEADER SECTION ---
                    $("#fd_campaign_name").text(d.campaign_name);
                    $("#fd_campaign_id").text(d.id);
                    $("#fd_timeline").text((d.start_date || '') + ' - ' + (d.end_date || ''));
                    renderPics(res.pics_main, "#fd_pics"); // Main PIC

                    // Priority
                    renderPriority(d.priority, "#fd_priority");

                    renderPlacement(d.placement, "#fd_placement");
                    // --- 1. CAMPAIGN BRIEF ---
                    $("#fd_goals").text(d.goals || '-');
                    $("#fd_big_idea").text(d.big_idea || '-');
                    $("#fd_description").html(d.description || '-');

                    // Influencer / Mediagram Display
                    if (res.influencer_ref.length > 0) {
                        $("#fd_brief_influencer_row").show();
                        renderInfluencerInfo(res.influencer_ref, "#fd_brief_influencer_row");
                    }

                    // Reference Links
                    let linksArr = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                    renderLinks(linksArr, "#fd_brief_link_container");

                    // Reference File
                    let briefPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/brief/";

                    // Panggil Helper (res.file_brief sekarang adalah array nama file)
                    renderFiles(res.file_brief, "#fd_brief_file_container", briefPath);

                    // --- 2. RISET SPV ---
                    $("#fd_riset_report").html(d.riset_report || '<span class="text-muted fst-italic">Belum ada data.</span>');
                    $("#fd_trend_analysis").html(d.trend_analysis || '<span class="text-muted fst-italic">Belum ada data.</span>');

                    renderPics(res.pics_riset, "#fd_riset_pic"); // PIC Riset
                    $("#fd_riset_note").text(d.riset_note || '-'); // Note

                    // Render Links Riset
                    renderLinks(d.riset_link, "#fd_riset_links");
                    // Render Files Riset
                    let risetPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/riset_spv/";
                    renderFiles(d.riset_file, "#fd_riset_files", risetPath);


                    // --- 3. CONTENT SCRIPT ---
                    $("#fd_naskah_final").html(d.naskah_final || '<span class="text-muted fst-italic">Belum ada naskah final.</span>');
                    renderPics(res.pics_script, "#fd_script_pic"); // PIC Script
                    $("#fd_script_note").text(d.script_note || '-'); // Note


                    // --- 4. RISET KOL ---
                    renderPics(res.pics_kol, "#fd_kol_pic"); // PIC KOL
                    $("#fd_kol_note").text(d.kol_note || '-'); // Note

                    // File Riset KOL (Global Proof)
                    let kolPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/riset_kol/";
                    renderFiles(d.kol_files, "#fd_kol_files", kolPath);

                    // Grid Items KOL
                    $("#fd_kol_container").empty();
                    if (res.kol_items && res.kol_items.length > 0) {
                        res.kol_items.forEach(item => {
                            let cpvIG = calculateCPV(item, 'ig');
                            let cpvTT = calculateCPV(item, 'tt');

                            // Generate View Badges (Simple version)
                            let viewsIG = item.konten_1_ig ? `<span class="badge bg-light text-dark border">Data Views Available</span>` : '';

                            let html = `
                        <div class="col-md-4">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                                    <span class="text-primary">${item.kol_nama}</span>
                                </div>
                                <div class="card-body small p-2">
                                    <div class="border-bottom pb-2 mb-2">
                                        <div class="d-flex justify-content-between fw-bold text-danger mb-1">
                                            <span>IG Rate</span> <span>${formatCurrencyDisplay(item.rate_card_ig)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between fw-bold text-success mb-1">
                                            <span>Followers</span> <span>${formatNumberDisplay(item.follower_ig) || 0}</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-muted bg-light p-1 rounded">
                                            <span>CPV Est.</span> <span>${cpvIG}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between fw-bold text-dark mb-1">
                                            <span>TT Rate</span> <span>${formatCurrencyDisplay(item.rate_card_tt)}</span>
                                        </div>
                                         <div class="d-flex justify-content-between fw-bold text-success mb-1">
                                            <span>Followers</span> <span>${formatNumberDisplay(item.follower_tt) || 0}</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-muted bg-light p-1 rounded">
                                            <span>CPV Est.</span> <span>${cpvTT}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                            $("#fd_kol_container").append(html);
                        });
                    } else {
                        $("#fd_kol_container").html('<div class="col-12 text-center text-muted p-3">Tidak ada data KOL approved.</div>');
                    }

                    // --- 5. BUDGETING ---
                    renderPics(res.pics_budget, "#fd_budget_pic"); // PIC Budgeting
                    $("#fd_budget_note").text(d.budget_note || '-'); // Note
                    if (d.budgeting_id) {
                        $("#fd_total_budget").text(formatCurrencyDisplay(d.total_budget));
                        $("#fd_penerima").text(d.nama_penerima || '-');
                        $("#fd_keperluan").text(d.nama_keperluan || '-');
                        let statusText = d.status_budget == 16 ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-warning">In Progress</span>';
                        $("#fd_status_budget").html(statusText);
                        $("#fd_no_eaf").text(d.eaf_ref_no || '-');
                    } else {
                        $("#fd_total_budget").text('Rp 0');
                        $("#fd_penerima").text('-');
                        $("#fd_keperluan").text('-');
                        $("#fd_status_budget").html('<span class="badge bg-secondary">Belum dimulai</span>');
                    }

                    // --- 6. SHOOTING ---
                    renderPics(res.pics_shooting, "#fd_shooting_pic"); // PIC Shooting
                    $("#fd_shooting_note").text(d.shooting_note || '-'); // Note
                    $("#fd_shooting_lokasi").text(d.lokasi || '-'); // Lokasi
                    $("#fd_shooting_keterangan").html(d.shooting_keterangan || '-'); // Tanggal
                    // Render Output Badges
                    if (res.shooting_output_nama && res.shooting_output_nama !== '-') {
                        let outs = res.shooting_output_nama.split(',');
                        let htmlOut = '';
                        outs.forEach(o => htmlOut += `<span class="badge bg-secondary">${o.trim()}</span> `);
                        $("#fd_shooting_output").html(htmlOut);
                    } else {
                        $("#fd_shooting_output").text('-');
                    }

                    // render link shooting
                    renderLinks(d.shooting_link, "#fd_shooting_link");
                    // render file shooting
                    let shootingPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/shooting/";
                    renderFiles(d.shooting_file, "#fd_shooting_files", shootingPath);

                    // --- 7. EDITING ---
                    $("#fd_editing_caption").html(d.editing_keterangan || '-'); // Caption
                    $("#fd_editing_note").html(d.editing_note || '-'); // Note
                    renderPics(res.pics_editing, "#fd_editing_pic"); // PIC Editing
                    renderLinks(d.editing_link, "#fd_editing_link");
                    // render file editing
                    let editingPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/editing/";
                    renderFiles(d.editing_file, "#fd_editing_thumbnail", editingPath);

                }
            }
        });
    }
</script>

<!-- riset SPV -->
<script>
    let uploadedRisetFiles = [];
    let dzRiset;

    // Inisialisasi Dropzone Riset
    dzRiset = new Dropzone("#dropzoneRiset", {
        url: "<?= base_url('marcom/upload_riset_temp_files'); ?>",
        maxFiles: 5,
        maxFilesize: 5,
        acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx",
        addRemoveLinks: true,
        dictRemoveFile: "<i class='fa fa-trash'></i>",
        init: function() {
            this.on("success", function(file, response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status) {
                        file.serverFileName = res.filename; // Simpan nama file server
                        uploadedRisetFiles.push(res.filename);
                    }
                } catch (e) {
                    console.log(e);
                }
            });
            this.on("removedfile", function(file) {
                let name = file.serverFileName || file.name; // Handle file baru atau existing
                uploadedRisetFiles = uploadedRisetFiles.filter(f => f !== name);
            });
        }
    });

    function loadRisetDetail(campaign_id) {

        // 1. Set ID ke Input Hidden (PENTING agar tidak null saat save)
        $("#riset_campaign_id").val(campaign_id);

        // 2. Reset Form & Variabel
        dzRiset.removeAllFiles(true);
        uploadedRisetFiles = [];
        $('#riset_report').summernote('code', '');
        $('#trend_analysis').summernote('code', '');

        clearElements([{
                id: "#risetLinkArea",
                action: "empty"
            },
            {
                id: "#r_placement",
                action: "html",
                value: ""
            }
        ]);


        // 3. Request Data
        $.ajax({
            url: baseUrl + "/get_riset_spv_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                // A. Info Campaign Header
                $("#r_campaign_name").text(res.campaign.campaign_name);
                $("#r_goals").text(res.campaign.goals);
                $("#r_big_idea").text(res.campaign.big_idea);
                $("#r_timeline").text(res.campaign.start_date + " → " + res.campaign.end_date);
                $('#r_deadline').text(res.deadline);

                // Description
                $("#r_description").html(res.campaign.description || '-');
                // Influencer/Mediagram Info
                renderInfluencerInfo(res.influencer_ref, "#r_influencer_container");

                // Links Campaign (Menggunakan helper)
                renderLinks(res.campaign.reference_link ? [res.campaign.reference_link, res.campaign.reference_link_2, res.campaign.reference_link_3].filter(Boolean).join(',') : null, "#r_camp_links");

                // Files Campaign (Menggunakan helper)
                let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/brief/";
                renderFiles(res.campaign.reference_file ? [res.campaign.reference_file, res.campaign.reference_file_2, res.campaign.reference_file_3].filter(Boolean).join(',') : null, "#r_camp_files", campPath);


                renderPics(res.pics, "#r_pic");

                renderPlacement(res.campaign.placement, "#r_placement");

                // B. Isi Form Existing Data (Jika ada)
                if (res.riset) {
                    $('#riset_report').summernote('code', res.riset.riset_report || '');
                    $('#trend_analysis').summernote('code', res.riset.trend_analysis || '');

                    // --- UPDATE 1: Link Logic (Split by comma) ---
                    if (res.riset.riset_link) {
                        let links = res.riset.riset_link.split(','); // Ubah string ke array
                        links.forEach(function(l) {
                            addRisetLinkInput(l); // Render input link
                        });
                    } else {
                        addRisetLinkInput(); // Render input link
                    }

                    // --- UPDATE 2: File Logic (Split by comma & Push to Array) ---
                    if (res.riset.riset_file) {
                        let dbFiles = res.riset.riset_file.split(','); // Ubah string ke array

                        dbFiles.forEach(function(filename) {
                            // 1. Wajib: Masukkan ke array global agar data file lama tidak hilang saat disimpan ulang
                            uploadedRisetFiles.push(filename);

                            // 2. Opsional: Tampilkan visual mock file di Dropzone agar user melihat file yang sudah ada
                            // Pastikan URL path sesuai lokasi penyimpanan controller
                            let imageUrl = "<?php echo base_url() ?>" + "/uploads/marcom/campaigns/" + campaign_id + "/riset_spv/" + filename;

                            let mockFile = {
                                name: filename,
                                size: 12345, // Dummy size karena tidak terbaca dari DB
                                serverFileName: filename // Properti custom untuk logic hapus
                            };

                            // Panggil API Dropzone untuk menampilkan file secara manual
                            dzRiset.emit("addedfile", mockFile);
                            // Jika file gambar, tampilkan thumbnail. Jika bukan, dropzone akan pakai icon default
                            if (filename.match(/\.(jpg|jpeg|png|gif)$/i)) {
                                dzRiset.emit("thumbnail", mockFile, imageUrl);
                            }
                            dzRiset.emit("complete", mockFile);

                            // Set maxFiles agar penghitungan limit file tetap akurat
                            dzRiset.files.push(mockFile);
                        });
                    }
                }
            },
            error: function(xhr) {
                console.error("Gagal memuat detail riset", xhr);
            }
        });
    }

    // Logic Tambah Input Link Dinamis
    $("#addRisetLink").click(function() {
        // 1. Hitung jumlah input link yang sudah ada
        let count = $("#risetLinkArea .link-item").length;

        // 2. Validasi Batas Maksimal (3)
        if (count >= 3) {
            $.alert({
                title: 'Batas Maksimum',
                content: 'Anda hanya dapat menambahkan maksimal 3 link riset.',
                type: 'orange',
                icon: 'fa fa-exclamation-triangle',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-orange'
                    }
                }
            });
            return; // Hentikan proses, jangan tambah input lagi
        }

        // 3. Jika belum mencapai batas, tambahkan input
        addRisetLinkInput("");
    });

    function addRisetLinkInput(value = "") {
        let html = `
        <div class="input-group mb-2 link-item">
            <span class="input-group-text"><i class="bi bi-link"></i></span>
            <input type="text" name="riset_link[]" class="form-control form-control-sm riset_url" value="${value}" placeholder="Masukkan URL Riset">
            <button type="button" class="btn btn-danger btn-sm remove-riset-link"><i class="bi bi-x"></i></button>
        </div>`;
        $("#risetLinkArea").append(html);
    }

    $(document).on('click', '.remove-riset-link', function() {
        $(this).closest('.link-item').remove();
    });

    // Save Logic Riset SPV
    $('#saveRisetSPV').click(function() {

        // Cek ID Campaign (Hidden)
        let cid = $("#riset_campaign_id").val();
        if (!cid) {
            showValidasi("Error: ID Campaign tidak ditemukan. Silakan refresh halaman.");
            return;
        }

        // Cek Riset Report (Summernote)
        if ($('#riset_report').summernote('isEmpty')) {
            showValidasi("Riset Report wajib diisi!");
            return;
        }

        // Cek Trend Analysis (Summernote)
        if ($('#trend_analysis').summernote('isEmpty')) {
            showValidasi("Trend Analysis wajib diisi!");
            return;
        }

        // --- [BARU] VALIDASI LINK ---
        let countLinks = 0;
        $(".riset_url").each(function() {
            // Cek apakah nilai input tidak kosong (setelah di-trim spasi)
            if ($.trim($(this).val()) !== "") {
                countLinks++;
            }
        });

        if (countLinks === 0) {
            showValidasi("Wajib menyertakan minimal satu Link Riset!");
            return;
        }

        // --- VALIDASI FILE ---
        // if (uploadedRisetFiles.length === 0) {
        //     showValidasi("Wajib upload minimal satu file lampiran riset!");
        //     return;
        // }

        // --- 2. PROSES SIMPAN ---
        let formData = new FormData();
        formData.append("campaign_id", cid);
        formData.append("riset_report", $('#riset_report').val());
        formData.append("trend_analysis", $('#trend_analysis').val());

        // Collect Links
        $(".riset_url").each(function() {
            if ($(this).val() !== "") {
                formData.append("riset_link[]", $(this).val());
            }
        });

        // Collect Files
        uploadedRisetFiles.forEach(f => formData.append("uploaded_riset_files[]", f));

        $.ajax({
            url: baseUrl + "/save_riset_spv",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    $("#modalRisetSPV").modal("hide");

                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Success',
                        theme: 'material',
                        type: 'green',
                        content: 'Data Riset berhasil disimpan!',
                        buttons: {
                            close: {
                                actions: function() {}
                            },
                        },
                    });

                    loadKanbanData(1); // Reload tab Riset SPV
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $.alert({
                    title: 'Error',
                    content: 'Gagal menyimpan data.',
                    type: 'red'
                });
            }
        });
    });

    // --- FUNGSI LOAD DATA REVIEW ---
    function loadReviewRiset(campaign_id) {
        // Reset Modal
        $("#rv_riset_report").html('<span class="text-muted fst-italic">Tidak ada data.</span>');
        $("#rv_trend_analysis").html('<span class="text-muted fst-italic">Tidak ada data.</span>');
        $("#approve_note").val('');
        $("#rv_files_list").empty();
        $("#rv_links_list").empty();

        $.ajax({
            url: baseUrl + "/get_review_riset_detail",
            type: "POST",
            data: {
                campaign_id: campaign_id
            },
            dataType: "json",
            beforeSend: function() {
                $("#rv_campaign_name").text("Loading...");
            },
            success: function(res) {
                if (res.status) {
                    const d = res.data;

                    // 1. Header & Meta
                    $("#rv_badge_id").text("ID: " + d.id);
                    $("#rv_hidden_campaign_id").val(d.id);
                    $("#rv_hidden_riset_id").val(d.riset_id); // ID tabel riset

                    $("#rv_campaign_name").text(d.campaign_name);
                    $("#rv_timeline").text((d.start_date || '?') + " → " + (d.end_date || '?'));
                    $("#rv_description").html(d.description || '-');
                    $("#rv_hist_goals").text(d.goals || '-');
                    $("#rv_hist_big_idea").text(d.big_idea || '-');

                    showDeadline(d.deadline, d.company_id, 'deadline_naskah');

                    // Influencer/Mediagram Info
                    renderInfluencerInfo(res.influencer_ref, "#rv_influencer_container");

                    // Links Campaign (Menggunakan helper)
                    renderLinks(d.reference_link ? [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean).join(',') : null, "#rv_hist_links");

                    // Files Campaign (Menggunakan helper)
                    let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/brief/";
                    renderFiles(d.reference_file ? [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean).join(',') : null, "#rv_hist_files", campPath);

                    // Priority Badge
                    let prioClass = d.priority == 3 ? 'bg-danger text-white' : (d.priority == 2 ? 'bg-warning text-dark' : 'bg-info text-white');
                    let prioText = d.priority == 3 ? 'High' : (d.priority == 2 ? 'Medium' : 'Low');
                    $("#rv_priority").html(`<span class="badge ${prioClass}">${prioText}</span>`);

                    // Placement Badge
                    renderPlacement(d.placement, "#rv_placement");

                    // PICs
                    renderPics(res.pics, "#rv_pics");

                    // 2. Riset Details (Isi dari Summernote ditampilkan sebagai HTML)
                    if (d.riset_report) $("#rv_riset_report").html(d.riset_report);
                    if (d.trend_analysis) $("#rv_trend_analysis").html(d.trend_analysis);
                    if (d.riset_note) $("#approve_note").val(d.riset_note);

                    // Render Files Riset SPV
                    let risetFilesPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/riset_spv/";
                    renderFiles(d.riset_files_arr ? d.riset_files_arr.join(',') : null, "#rv_files_list", risetFilesPath);

                    // Render Links Riset SPV
                    renderLinks(d.riset_links_arr ? d.riset_links_arr.join(',') : null, "#rv_links_list");

                } else {
                    alert(res.message);
                    $("#modalReviewRiset").modal("hide");
                }
            },
            error: function(err) {
                console.error(err);
                alert("Gagal mengambil data review.");
            }
        });
    }

    // --- FUNGSI SUBMIT APPROVAL RISET SPV ---
    $("#btnApproveRiset").click(function() {



        const cid = $("#rv_hidden_campaign_id").val();
        const rid = $("#rv_hidden_riset_id").val();
        const note = $.trim($("#approve_note").val()); // Hapus spasi depan/belakang
        const pic = $('#picSelectReviewSpv').val(); // Array value dari SlimSelect
        const deadline = $("#deadline_naskah").val();

        // Validasi ID Riset (System Check)
        if (!rid) {
            showValidasi("Data Riset tidak valid (Belum dimulai/disimpan).");
            return;
        }

        // Validasi Catatan Approval
        if (note === "") {
            showValidasi("Mohon isi <b>Catatan Approval</b> terlebih dahulu!");
            return;
        }

        if (deadline === "") {
            showValidasi("Mohon isi <b>Deadline</b> untuk tahap selanjutnya!");
            return;
        }

        // Validasi Next PIC
        if (!pic || pic.length === 0) {
            showValidasi("Mohon pilih <b>Next PIC</b> untuk tahap selanjutnya (Riset KOL)!");
            return;
        }

        const listPic = pic.join(",");

        // --- 2. PROSES APPROVE ---
        $.confirm({
            title: 'Konfirmasi Approval',
            content: 'Apakah Anda yakin ingin menyetujui Riset ini?<br>Task akan dipindahkan ke Completed dan Script Task akan dibuat.',
            type: 'blue',
            buttons: {
                confirm: {
                    text: 'Ya, Approve',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.ajax({
                            url: baseUrl + "/approve_riset_spv",
                            type: "POST",
                            data: {
                                campaign_id: cid,
                                riset_id: rid,
                                note: note,
                                pic: listPic,
                                deadline_naskah: deadline
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.status) {
                                    $("#modalReviewRiset").modal("hide");

                                    sendNotifApprove(cid, 2);
                                    // Reload Kanban
                                    loadKanbanData(1);

                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Success',
                                        theme: 'material',
                                        type: 'green',
                                        content: 'Riset berhasil di-approve!',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });

                                    // Refresh Tab Content Script juga karena ada task baru masuk
                                    renderKanban(2);
                                    initDragula(2);
                                } else {
                                    $.alert({
                                        title: 'Error',
                                        type: 'red',
                                        content: res.message
                                    });
                                }
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>

<!-- content script -->
<script>
    function loadScriptDetail(campaign_id) {
        // Reset Form
        $('#naskah_1').summernote('code', '');
        $('#naskah_2').summernote('code', '');
        $('#naskah_3').summernote('code', '');
        $('#wrap_naskah_2, #wrap_naskah_3').hide();
        $('#btnAddNaskah').show();
        $("#script_campaign_id").val(campaign_id);
        $("#hist_riset_links").html('<span class="text-muted small fst-italic">- Tidak ada link -</span>');
        $("#hist_riset_files").html('<span class="text-muted small fst-italic">- Tidak ada file -</span>');

        $.ajax({
            url: baseUrl + "/get_script_detail",
            type: "POST",
            data: {
                campaign_id: campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    const d = res.data;

                    // Isi Hidden Field untuk AI
                    $("#script_campaign_name_hid").val(d.campaign_name);
                    $("#s_campaign_name").text(d.campaign_name);
                    $("#h_script_goals").text(d.goals || '-');
                    $("#h_script_big_idea").text(d.big_idea || '-');

                    $("#s_timeline").text(d.start_date + " - " + d.end_date);
                    $("#s_deadline").text(d.deadline || d.end_date);

                    $("#s_description").html(d.description || '-');

                    // Influencer/Mediagram Info
                    renderInfluencerInfo(res.influencer_ref, "#h_influencer_container");

                    let campLinks = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                    renderLinks(campLinks, "#h_script_camp_links");

                    let campFiles = [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean);
                    let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/brief/";
                    renderFiles(campFiles, "#h_script_camp_files", campPath);

                    // 2. ISI HISTORY RISET SPV
                    $("#h_script_riset_note").text(d.riset_note || '- Tidak ada note -');
                    $("#h_script_riset_report").html(d.riset_report || '-');
                    $("#h_script_trend_analysis").html(d.trend_analysis || '-');

                    renderLinks(d.riset_link, "#h_script_riset_links");
                    let risetPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/riset_spv/";
                    renderFiles(d.riset_file, "#h_script_riset_files", risetPath);

                    renderPics(res.pics, "#s_pic");

                    // Badge Priority
                    let prioClass = d.priority == 3 ? 'badge-high' : (d.priority == 2 ? 'badge-medium' : 'badge-low');
                    let prioText = d.priority == 3 ? 'High' : (d.priority == 2 ? 'Medium' : 'Low');
                    $("#s_priority").html(`<span class="badge badge-priority ${prioClass}">${prioText}</span>`);

                    // Badge Placement
                    // let placeText = d.placement == 1 ? 'IG' : (d.placement == 2 ? 'TikTok' : (d.placement == 3 ? 'Influencer' : 'Mediagram'));
                    // $("#s_placement").html(`<span class="badge bg-secondary">${placeText}</span>`);

                    renderPlacement(d.placement, "#s_placement");

                    // B. Isi Naskah Existing
                    if (d.naskah) $('#naskah_1').summernote('code', d.naskah);

                    if (d.naskah_2) {
                        $('#wrap_naskah_2').show();
                        $('#naskah_2').summernote('code', d.naskah_2);
                    }
                    if (d.naskah_3) {
                        $('#wrap_naskah_3').show();
                        $('#naskah_3').summernote('code', d.naskah_3);
                        $('#btnAddNaskah').hide(); // Max 3 reached
                    }

                    // C. Riwayat Inputan (Riset Market)
                    $("#hist_riset_report").html(d.riset_report || '<span class="text-muted fst-italic">Belum ada data riset.</span>');
                    $("#hist_trend_analysis").html(d.trend_analysis || '<span class="text-muted fst-italic">Belum ada trend analysis.</span>');
                }
            }
        });
    }

    function delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    // --- 4. LOGIC TOMBOL GENERATE AI ---
    $("#btnGenerateAI").click(function() {
        let btn = $(this);
        let originalText = btn.html();

        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Generating...');

        $("#btnAddNaskah").trigger('click');
        $("#btnAddNaskah").trigger('click');

        showLoader({
            text: `Generating...`,
            type: 'border'
        });
        $.ajax({
            url: baseUrl + "/generate_script",
            type: "POST",
            data: {
                campaign_id: $("#script_campaign_id").val()
            },
            dataType: "json",
            success: function(res) {
                // Masukkan ke Naskah 1 (atau append)
                // console.log(res);
                hideLoader();
                // let current = $('#naskah_1').summernote('code');
                // $('#naskah_2').summernote('code')
                // $('#naskah_3').summernote('code')
                delay(1500).then(() => {
                    let newContent = res.data;
                    let naskah_1 = res.naskahList[0] + "<br>---------------------------------<br><br>" + res.naskahList[1];
                    let naskah_2 = res.naskahList[0] + "<br>---------------------------------<br><br>" + res.naskahList[2];
                    let naskah_3 = res.naskahList[0] + "<br>---------------------------------<br><br>" + res.naskahList[3];

                    // Timpa atau tambah? Biasanya timpa kalau kosong, tambah kalau isi.
                    // Disini kita insert saja.
                    $('#naskah_1').summernote('focus');
                    $('#naskah_1').summernote('code', naskah_1);
                    $('#naskah_2').summernote('focus');
                    $('#naskah_2').summernote('code', naskah_2);
                    $('#naskah_3').summernote('focus');
                    $('#naskah_3').summernote('code', naskah_3);


                    btn.prop('disabled', false).html(originalText);
                    showSuccess('Naskah berhasil digenerate oleh AI!');
                })
            },
            error: function() {
                btn.prop('disabled', false).html(originalText);
                $.alert({
                    title: 'Error',
                    content: 'Gagal menghubungi server AI. Silakan coba lagi.',
                    type: 'red',
                    icon: 'fa fa-times-circle',
                    buttons: {
                        close: {
                            actions: function() {}
                        },
                    },
                })
            }
        });
    });


    // --- 5. LOGIC TAMBAH & HAPUS OPSI NASKAH ---
    $("#btnAddNaskah").click(function() {
        console.log('tambah');

        if (!$('#wrap_naskah_2').is(':visible')) {
            $('#wrap_naskah_2').fadeIn();
            console.log('tambah2');
        } else if (!$('#wrap_naskah_3').is(':visible')) {
            $('#wrap_naskah_3').fadeIn();
            $(this).hide(); // Max limit
            console.log('tambah3');
        }
    });

    $(".remove-naskah").click(function() {
        let target = $(this).data('target'); // 2 or 3

        if (target == 2) {
            // Jika hapus no 2, tapi no 3 ada? Idealnya geser, tapi simplenya hide & clear saja
            // Tapi karena strukturnya fixed column db, kita clear value & hide
            $('#naskah_2').summernote('code', '');
            $('#wrap_naskah_2').fadeOut();
        } else if (target == 3) {
            $('#naskah_3').summernote('code', '');
            $('#wrap_naskah_3').fadeOut();
            $('#btnAddNaskah').show(); // Show add button again
        }
    });

    // --- 6. SIMPAN SCRIPT DENGAN VALIDASI ---
    $("#btnSaveScript").click(function() {



        let cid = $("#script_campaign_id").val();

        // Cek ID (System check)
        if (!cid) {
            showValidasi("Error: ID Campaign tidak ditemukan.");
            return;
        }

        // Cek Naskah 1 (Wajib)
        if ($('#naskah_1').summernote('isEmpty')) {
            showValidasi("<b>Naskah Utama (Opsi 1)</b> tidak boleh kosong!");
            return;
        }

        // Cek Naskah 2 (Jika ditampilkan)
        if ($('#wrap_naskah_2').is(':visible') && $('#naskah_2').summernote('isEmpty')) {
            showValidasi("Anda mengaktifkan <b>Opsi Naskah 2</b>, mohon isi kontennya atau hapus opsi ini.");
            return;
        }

        // Cek Naskah 3 (Jika ditampilkan)
        if ($('#wrap_naskah_3').is(':visible') && $('#naskah_3').summernote('isEmpty')) {
            showValidasi("Anda mengaktifkan <b>Opsi Naskah 3</b>, mohon isi kontennya atau hapus opsi ini.");
            return;
        }

        // --- 2. PROSES SIMPAN ---
        $.ajax({
            url: baseUrl + "/save_script",
            type: "POST",
            data: {
                campaign_id: cid,
                naskah: $('#naskah_1').val(),
                naskah_2: $('#naskah_2').val(), // Summernote value
                naskah_3: $('#naskah_3').val()
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    $("#modalContentScript").modal("hide");

                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Success',
                        theme: 'material',
                        type: 'green',
                        content: 'Content Script berhasil disimpan!',
                        buttons: {
                            close: {
                                actions: function() {}
                            },
                        },
                    });

                    loadKanbanData(2); // Reload Tab 2
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $.alert('Gagal menyimpan naskah.');
            }
        });
    });

    function initSlimSelectReview(selector, company_id, modalId) {
        $(selector).empty();

        if (!company_id) return;
        $.ajax({
            url: baseUrl + "/get_pic_by_company",
            type: "POST",
            data: {
                company_id
            },
            dataType: "json",
            success: function(res) {
                const options = res.map(row => ({
                    text: row.full_name + '|' + row.designation_name,
                    value: row.user_id
                }));

                new SlimSelect({
                    select: selector,
                    data: options,
                    settings: {
                        showSearch: true,
                        searchText: 'Cari PIC...',
                        placeholderText: 'Pilih Next PIC...',
                        allowDeselect: true,
                        closeOnSelect: true,
                        // TAMBAHAN: Render di dalam modal spesifik
                        contentLocation: document.getElementById(modalId)
                    }
                });
            }
        });
    }

    // --- 2. FUNGSI LOAD DATA REVIEW SCRIPT ---
    function loadReviewScript(campaign_id, isCompleted = false) {
        // Reset
        $("#naskahContainer").empty();
        $("#approve_script_note").val('');
        $("#selected_naskah_content").val('');
        $("#rvs_campaign_name").text('Loading...');

        $("#rvs_riset_report").html('<span class="text-muted small fst-italic">-</span>');
        $("#rvs_trend_analysis").html('<span class="text-muted small fst-italic">-</span>');
        $("#rvs_riset_links").html('<span class="text-muted small fst-italic">- Tidak ada link -</span>');
        $("#rvs_riset_files").html('<span class="text-muted small fst-italic">- Tidak ada file -</span>');

        $.ajax({
            url: baseUrl + "/get_review_script_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    const d = res.data;

                    // Set Hidden ID & Header Info (Sama seperti sebelumnya)
                    $("#rvs_hidden_campaign_id").val(d.id);
                    $("#rvs_hidden_script_id").val(d.script_id);
                    $("#rvs_campaign_name").text(d.campaign_name);
                    $("#rvs_hist_goals").text(d.goals);
                    $("#rvs_deadline").text(d.deadline_script || d.end_date);
                    $("#rvs_hist_big_idea").text(d.big_idea);
                    $("#rvs_timeline").text((d.start_date || '') + ' - ' + (d.end_date || ''));
                    $("#rvs_description").html(d.description);
                    if (d.note_approve) $("#approve_script_note").val(d.note_approve);

                    showDeadline(d.deadline, d.company_id, 'deadline_kol');

                    $("#rvs_riset_note").html(d.riset_note || '<span class="text-muted small fst-italic">Belum ada data.</span>');
                    $("#rvs_riset_report").html(d.riset_report || '<span class="text-muted small fst-italic">Belum ada data.</span>');
                    $("#rvs_trend_analysis").html(d.trend_analysis || '<span class="text-muted small fst-italic">Belum ada data.</span>');

                    let prioClass = d.priority == 3 ? 'badge-high' : (d.priority == 2 ? 'badge-medium' : 'badge-low');
                    let prioText = d.priority == 3 ? 'High' : (d.priority == 2 ? 'Medium' : 'Low');
                    $("#rvs_priority").html(`<span class="badge badge-priority ${prioClass}">${prioText}</span>`);

                    // Badge Placement
                    renderPlacement(d.placement, "#rvs_placement");

                    renderPics(res.pics, "#rvs_pic");

                    renderInfluencerInfo(res.influencer_ref, "#rvs_influencer_container");

                    // Links Campaign (Menggunakan helper)
                    renderLinks(d.reference_link ? [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean).join(',') : null, "#rvs_hist_links");

                    // Files Campaign (Menggunakan helper)
                    let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/brief/";
                    renderFiles(d.reference_file ? [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean).join(',') : null, "#rvs_hist_files", campPath);

                    if (d.riset_link) {
                        renderLinks(d.riset_link, "#rvs_riset_links");
                    }

                    // Parse File
                    if (d.riset_file) {
                        let basePath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/riset_spv/";
                        renderFiles(d.riset_file, "#rvs_riset_files", basePath);
                    }

                    // --- LOGIKA BARU UNTUK DISPLAY NASKAH ---

                    if (isCompleted && d.naskah_final) {
                        // KONDISI 1: COMPLETED -> Tampilkan HANYA Naskah Final
                        let finalHtml = `
                        <div class="col-12">
                            <div class="card h-100 border-success shadow-sm">
                                <div class="card-header bg-success text-white d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <span class="fw-bold">Naskah Final (Approved)</span>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="naskah-content-raw p-2">${d.naskah_final}</div>
                                </div>
                            </div>
                        </div>`;
                        $("#naskahContainer").html(finalHtml);

                    } else {
                        // KONDISI 2: REVIEW -> Tampilkan Pilihan Opsi (Radio Button)
                        let naskahList = [{
                                id: 'opt1',
                                title: 'Opsi Naskah 1',
                                content: d.naskah
                            },
                            {
                                id: 'opt2',
                                title: 'Opsi Naskah 2',
                                content: d.naskah_2
                            },
                            {
                                id: 'opt3',
                                title: 'Opsi Naskah 3',
                                content: d.naskah_3
                            },
                            // {
                            //     id: 'optAI',
                            //     title: 'Naskah AI',
                            //     content: d.naskah_ai
                            // }
                        ];

                        naskahList.forEach(n => {
                            if (n.content && n.content.trim() !== "") {
                                let html = `
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-header bg-white d-flex align-items-center justify-content-between">
                                            <span class="fw-bold text-primary">${n.title}</span>
                                            <div class="form-check">
                                                <input class="form-check-input naskah-radio" type="radio" name="final_naskah_opt" id="radio_${n.id}" value="${n.id}">
                                                <label class="form-check-label fw-bold small cursor-pointer" for="radio_${n.id}">Pilih</label>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light overflow-auto" style="max-height: 200px;">
                                            <div class="small naskah-content-raw" id="content_${n.id}">${n.content}</div>
                                        </div>
                                    </div>
                                </div>`;
                                $("#naskahContainer").append(html);
                            }
                        });

                        // Event listener radio button
                        $(".naskah-radio").change(function() {
                            let id = $(this).val();
                            let content = $(`#content_${id}`).html();
                            $("#selected_naskah_content").val(content);
                            $(".card").removeClass("border-success border-2");
                            $(this).closest(".card").addClass("border-success border-2");
                        });
                    }

                } else {
                    alert(res.message);
                    $("#modalReviewScript").modal("hide");
                }
            }
        });
    }

    // --- 3. TOMBOL APPROVE SCRIPT DENGAN VALIDASI LENGKAP ---
    $("#btnApproveScript").click(function() {



        const cid = $("#rvs_hidden_campaign_id").val();
        const sid = $("#rvs_hidden_script_id").val();
        const finalContent = $("#selected_naskah_content").val();
        const note = $.trim($("#approve_script_note").val()); // Hapus spasi kosong
        const pic = $('#picSelectReviewScript').val(); // Array value
        const deadline = $("#deadline_kol").val();

        // Validasi 1: Pilih Naskah
        if (!finalContent) {
            showValidasi("Silakan pilih salah satu <b>Naskah Final</b> (Opsi 1/2/3/AI) terlebih dahulu!");
            return;
        }

        // Validasi 2: Catatan Approval
        if (note === "") {
            showValidasi("Mohon isi <b>Catatan Approval</b>!");
            return;
        }

        if (deadline === "") {
            showValidasi("Mohon isi <b>Deadline</b> untuk tahap selanjutnya!");
            return;
        }

        // Validasi 3: Next PIC
        if (!pic || pic.length === 0) {
            showValidasi("Mohon pilih <b>Next PIC</b> untuk tahap selanjutnya (Riset KOL)!");
            return;
        }

        const listPic = pic.join(",");

        // --- 2. PROSES APPROVE ---
        $.confirm({
            title: 'Konfirmasi Approval',
            content: 'Naskah final akan disimpan dan Task akan dipindahkan ke Riset KOL (Tab 3). Lanjutkan?',
            type: 'green',
            buttons: {
                confirm: {
                    text: 'Ya, Approve',
                    btnClass: 'btn-success',
                    action: function() {
                        $.ajax({
                            url: baseUrl + "/approve_script",
                            type: "POST",
                            data: {
                                campaign_id: cid,
                                script_id: sid,
                                naskah_final: finalContent,
                                note: note,
                                pic: listPic,
                                deadline_kol: deadline
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.status) {
                                    $("#modalReviewScript").modal("hide");
                                    sendNotifApprove(cid, 3);

                                    showSuccess('Naskah Approved! Task moved to Riset KOL!');

                                    // Reload Data Kanban
                                    loadKanbanData(2); // Refresh Tab Script
                                } else {
                                    $.alert({
                                        title: 'Error',
                                        content: res.message,
                                        type: 'red'
                                    });
                                }
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });

    // ==========================================
    // 🔙 LOGIC CANCEL / REJECT (BACK TO PROGRESS)
    // ==========================================

    // 1. REJECT RISET (Tab 1: Status 3 -> 2)
    $("#btnRejectRiset").click(function() {
        const id = $("#rv_hidden_campaign_id").val();

        $.confirm({
            title: 'Revisi Riset',
            content: 'Kembalikan status ke <b>In Progress</b> untuk direvisi?',
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'Ya, Kembalikan',
                    btnClass: 'btn-warning',
                    action: function() {
                        // Panggil API update_progress: ID, Tab 1, Status 2 (In Progress), Old 3
                        sendNotifReject(id, 1);
                        updateProgressBackend(id, 1, 2, 3);
                        $("#modalReviewRiset").modal("hide");
                        loadKanbanData(1);
                        $.alert({
                            title: 'Revisi!',
                            content: 'Task dikembalikan ke In Progress.',
                            type: 'orange',
                            icon: 'fa fa-exclamation-triangle',
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });

    // 2. REJECT SCRIPT (Tab 2: Status 7 -> 6)
    $("#btnRejectScript").click(function() {
        const id = $("#rvs_hidden_campaign_id").val();

        $.confirm({
            title: 'Revisi Script',
            content: 'Kembalikan status ke <b>In Progress</b> untuk direvisi?',
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'Ya, Kembalikan',
                    btnClass: 'btn-warning',
                    action: function() {
                        sendNotifReject(id, 2);
                        // Panggil API update_progress: ID, Tab 2, Status 6 (In Progress), Old 7
                        updateProgressBackend(id, 2, 6, 7);
                        $("#modalReviewScript").modal("hide");
                        loadKanbanData(2);
                        $.alert({
                            title: 'Revisi!',
                            content: 'Task dikembalikan ke In Progress.',
                            type: 'orange',
                            icon: 'fa fa-exclamation-triangle',
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>

<!-- Riset KOL -->
<script>
    // --- LOGIC RISET KOL (MULTIPLE) ---

    let uploadedKOLFiles = [];
    let dzRisetKOL;

    // Init Dropzone (Multiple Files)
    dzRisetKOL = new Dropzone("#dropzoneRisetKOL", {
        url: "<?= base_url('marcom/upload_riset_kol_temp'); ?>",
        maxFiles: 10,
        maxFilesize: 5,
        acceptedFiles: "image/*,application/pdf", // Support PDF juga jika bukti chat
        addRemoveLinks: true,
        dictRemoveFile: "<i class='fa fa-trash'></i>",
        init: function() {
            this.on("success", function(file, response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status) {
                        file.serverFileName = res.filename;
                        uploadedKOLFiles.push(res.filename);
                    }
                } catch (e) {}
            });
            this.on("removedfile", function(file) {
                let name = file.serverFileName || file.name;
                uploadedKOLFiles = uploadedKOLFiles.filter(f => f !== name);
            });
        }
    });

    let kolMasterList = []; // Simpan list KOL dari API agar tidak request berulang saat Add Item

    // --- Helper: Cek Visibility Tombol Hapus ---
    function updateDeleteButtonVisibility() {
        let count = $(".kol-item-card").length;
        if (count <= 1) {
            $(".remove-kol-item").hide(); // Sembunyikan jika cuma 1
        } else {
            $(".remove-kol-item").show(); // Tampilkan jika lebih dari 1
        }
    }

    // --- Template HTML untuk Item KOL ---
    function createKOLItemHTML(index, data = null) {
        let uniqueId = Date.now() + Math.random().toString(36).substr(2, 5);
        const val = (v) => (data && v != null) ? formatNumberDisplay(v) : '';

        // ... (Bagian HTML Template sama seperti yang Anda kirim, hanya tambahkan class 'remove-kol-item' di button)
        let html = `
        <div class="card border-0 shadow-sm mb-3 kol-item-card" id="item_${uniqueId}">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary item-title">Data KOL #${index + 1}</span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-kol-item" onclick="removeKOLItem('${uniqueId}')">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                    <label class="small fw-bold mb-1">Pilih KOL</label>
                    <div class="w-100"> 
                        <select name="kol_id[]" class="kol-select" id="select_${uniqueId}"></select>
                    </div>
                </div>
                    <div class="col-md-3">
                        <label class="small fw-bold mb-1"><i class="bi bi-instagram"></i> Followers IG</label>
                        <input type="text" name="follower_ig[]" class="form-control form-control-sm" oninput="formatInputNumber(this)" value="${data ? (data.follower_ig || data.follower) : ''}" placeholder="IG Follower"> 
                        </div>
                    <div class="col-md-3">
                        <label class="small fw-bold mb-1"><i class="bi bi-tiktok"></i> Followers TT</label>
                        <input type="text" name="follower_tt[]" class="form-control form-control-sm" oninput="formatInputNumber(this)" value="${data ? data.follower_tt : ''}" placeholder="TT Follower">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-white h-100">
                            <label class="fw-bold text-danger mb-2"><i class="bi bi-instagram"></i> Instagram Views (Last 5)</label>
                            <div class="row g-2 mb-2">
                                <div class="col-4"><input type="text" name="konten_1_ig[]" class="form-control form-control-sm" placeholder="Views Last Konten 1" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_1_ig)}"></div>
                                <div class="col-4"><input type="text" name="konten_2_ig[]" class="form-control form-control-sm" placeholder="Views Last Konten 2" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_2_ig)}"></div>
                                <div class="col-4"><input type="text" name="konten_3_ig[]" class="form-control form-control-sm" placeholder="Views Last Konten 3" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_3_ig)}"></div>
                                <div class="col-6"><input type="text" name="konten_4_ig[]" class="form-control form-control-sm" placeholder="Views Last Konten 4" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_4_ig)}"></div>
                                <div class="col-6"><input type="text" name="konten_5_ig[]" class="form-control form-control-sm" placeholder="Views Last Konten 5" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_5_ig)}"></div>
                            </div>
                            <label class="small fw-bold mt-2">Rate Card IG</label>
                            <input type="text" name="rate_card_ig[]" class="form-control form-control-sm" placeholder="Rp 0" oninput="formatInputCurrency(this) ; calculateECPV('${uniqueId}')" value="${val(data?.rate_card_ig)}">
                            <label class="small fw-bold mt-2">ECPV IG</label>
                            <input type="text" name="ecpv_ig[]" id="ecpv_ig_${uniqueId}" class="form-control form-control-sm bg-light" placeholder="ECPV IG" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-white h-100">
                            <label class="fw-bold text-dark mb-2"><i class="bi bi-tiktok"></i> TikTok Views (Last 5)</label>
                            <div class="row g-2 mb-2">
                                <div class="col-4"><input type="text" name="konten_1_tt[]" class="form-control form-control-sm" placeholder="Views Last Konten 1" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_1_tt)}"></div>
                                <div class="col-4"><input type="text" name="konten_2_tt[]" class="form-control form-control-sm" placeholder="Views Last Konten 2" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_2_tt)}"></div>
                                <div class="col-4"><input type="text" name="konten_3_tt[]" class="form-control form-control-sm" placeholder="Views Last Konten 3" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_3_tt)}"></div>
                                <div class="col-6"><input type="text" name="konten_4_tt[]" class="form-control form-control-sm" placeholder="Views Last Konten 4" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_4_tt)}"></div>
                                <div class="col-6"><input type="text" name="konten_5_tt[]" class="form-control form-control-sm" placeholder="Views Last Konten 5" oninput="formatInputNumber(this); calculateECPV('${uniqueId}')" value="${val(data?.konten_5_tt)}"></div>
                            </div>
                            <label class="small fw-bold mt-2">Rate Card TikTok</label>
                            <input type="text" name="rate_card_tt[]" class="form-control form-control-sm" placeholder="Rp 0" oninput="formatInputCurrency(this) ; calculateECPV('${uniqueId}')" value="${val(data?.rate_card_tt)}">
                            <label class="small fw-bold mt-2">ECPV TikTok</label>
                            <input type="text" name="ecpv_tt[]" id="ecpv_tt_${uniqueId}" class="form-control form-control-sm bg-light" placeholder="ECPV TikTok" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $("#kolItemsContainer").append(html);



        // ... (SlimSelect Init sama) ...
        let options = kolMasterList.map(k => ({
            text: k.nama,
            value: k.id,
            selected: (data && data.kol_id == k.id)
        }));
        options.unshift({
            text: 'Pilih KOL...',
            value: '',
            placeholder: true
        });

        new SlimSelect({
            select: `#select_${uniqueId}`,
            data: options,
            settings: {
                showSearch: true,
                searchText: 'Cari KOL...',
                placeholderText: 'Pilih KOL...',
                allowDeselect: true,
                // PERBAIKAN UTAMA:
                // Render di body agar posisi dihitung absolut terhadap layar, bukan relatif terhadap wrapper card
                contentLocation: document.getElementById('modalRisetKOL'),
                openPosition: 'auto'
            }
        });

        if (data) {
            calculateECPV(uniqueId);
        }

        // 1. Cek limit Max (5)
        checkMaxLimit();
        // 2. Cek limit Min (1) -> Sembunyikan tombol hapus jika cuma 1
        updateDeleteButtonVisibility();
    }

    function calculateECPV(uniqueId) {
        // IG
        let totalIG = 0,
            countIG = 0;
        for (let i = 1; i <= 5; i++) {
            let val = $(`#item_${uniqueId} input[name="konten_${i}_ig[]"]`).val().replace(/\D/g, '');
            if (val) {
                totalIG += parseInt(val);
                countIG++;
            }
        }
        let rateIG = $(`#item_${uniqueId} input[name="rate_card_ig[]"]`).val().replace(/\D/g, '');
        let ecpvIG = '';
        if (countIG > 0 && rateIG) {
            let avgIG = totalIG / countIG;
            if (avgIG > 0) ecpvIG = Math.round(parseInt(rateIG) / avgIG);
        }
        $(`#ecpv_ig_${uniqueId}`).val(formatCurrencyDisplay(ecpvIG));

        // TikTok
        let totalTT = 0,
            countTT = 0;
        for (let i = 1; i <= 5; i++) {
            let val = $(`#item_${uniqueId} input[name="konten_${i}_tt[]"]`).val().replace(/\D/g, '');
            if (val) {
                totalTT += parseInt(val);
                countTT++;
            }
        }
        let rateTT = $(`#item_${uniqueId} input[name="rate_card_tt[]"]`).val().replace(/\D/g, '');
        let ecpvTT = '';
        if (countTT > 0 && rateTT) {
            let avgTT = totalTT / countTT;
            if (avgTT > 0) ecpvTT = Math.round(parseInt(rateTT) / avgTT);
        }
        $(`#ecpv_tt_${uniqueId}`).val(formatCurrencyDisplay(ecpvTT));
    }

    // Fungsi Hapus Item (UPDATED)
    window.removeKOLItem = function(id) {
        $(`#item_${id}`).remove();

        checkMaxLimit();
        updateDeleteButtonVisibility(); // Update tombol hapus

        // Re-index titles
        $(".kol-item-card").each(function(idx) {
            $(this).find(".item-title").text(`Data KOL #${idx + 1}`);
        });
    }

    function checkMaxLimit() {
        let count = $(".kol-item-card").length;
        if (count >= 5) $("#btnAddKOLItem").hide();
        else $("#btnAddKOLItem").show();
    }

    $("#btnAddKOLItem").click(function() {
        let count = $(".kol-item-card").length;
        createKOLItemHTML(count);
    });

    // LOAD RISET KOL (Modified for Multiple)
    function loadRisetKOLDetail(campaign_id) {
        $("#kol_campaign_id").val(campaign_id);
        dzRisetKOL.removeAllFiles(true);
        uploadedKOLFiles = [];

        // Reset Header UI
        clearElements([{
                id: "#kolItemsContainer",
                action: "empty"
            },
            {
                id: "#k_pic_list",
                action: "empty"
            },

            {
                id: "#k_goals",
                action: "text"
            },
            {
                id: "#k_big_idea",
                action: "text"
            },

            {
                id: "#k_description",
                action: "html"
            },
            {
                id: "#k_script_note",
                action: "text"
            }
        ]);


        $.ajax({
            url: baseUrl + "/get_riset_kol_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    const d = res.data;
                    kolMasterList = res.kols; // Simpan ke global variable

                    // Header Info (Sama)
                    $("#k_campaign_name").text(d.campaign_name);
                    $("#k_timeline").text(d.start_date + ' - ' + d.end_date);
                    renderPlacement(d.placement, "#k_placement");

                    renderPriority(d.priority, "#k_priority");

                    $('#k_deadline').text(d.deadline || d.end_date);

                    $("#k_goals").text(d.goals || '-');
                    $("#k_deadline").text(d.deadline || d.end_date);
                    $("#k_big_idea").text(d.big_idea || '-');
                    $("#k_description").html(d.description || '-');

                    let campLinks = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                    renderLinks(campLinks, "#k_camp_links"); // Menggunakan helper renderLinks

                    let campFiles = [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean);
                    let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/brief/";
                    renderFiles(campFiles, "#k_camp_files", campPath); // Menggunakan helper renderFiles

                    renderInfluencerInfo(res.influencer_ref, "#k_influencer_container");

                    // 2. ISI HISTORY RISET SPV
                    $("#k_riset_report").html(d.riset_report || '-');
                    $("#k_trend_analysis").html(d.trend_analysis || '-');
                    $("#k_riset_note").text(d.riset_note || '-');

                    renderLinks(d.riset_link, "#k_riset_links");

                    // 2. Render File (Support Banyak File)
                    // Data d.riset_file otomatis akan di-split oleh helper renderFiles
                    let risetSpvPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/riset_spv/";
                    renderFiles(d.riset_file, "#k_riset_files", risetSpvPath);

                    // 3. ISI HISTORY SCRIPT
                    $("#k_naskah_final").html(d.naskah_final || '<span class="text-muted">Belum ada naskah final.</span>');
                    let noteHtml = d.script_note ?
                        d.script_note :
                        '<span class="text-muted opacity-50">Tidak ada catatan approval.</span>';
                    $("#k_script_note").html(noteHtml);

                    // PIC

                    renderPics(res.pics, "#k_pic_list");

                    // Render Items (Looping Data Detail)
                    if (res.items && res.items.length > 0) {
                        res.items.forEach((item, idx) => {
                            createKOLItemHTML(idx, item);
                        });
                    } else {
                        // Jika kosong, tambah 1 form default
                        createKOLItemHTML(0);
                    }

                    // Render Files Global
                    if (res.files) {
                        res.files.forEach(f => {
                            uploadedKOLFiles.push(f.name);
                            let mock = {
                                name: f.name,
                                size: 12345,
                                serverFileName: f.name
                            };
                            dzRisetKOL.emit("addedfile", mock);
                            // Cek jika gambar, tampilkan thumbnail
                            if (f.name.match(/\.(jpg|jpeg|png|gif)$/i)) {
                                dzRisetKOL.emit("thumbnail", mock, f.url);
                            }
                            dzRisetKOL.emit("complete", mock);
                            dzRisetKOL.files.push(mock);
                        });
                    }
                }
            }
        });
    }

    // SAVE RISET KOL
    $("#btnSaveRisetKOL").click(function() {

        // --- 1. VALIDASI ---
        let isValid = true;
        let errorMessage = "";



        // Cek Item Exist
        if ($(".kol-item-card").length === 0) {
            showValidasi("Mohon tambahkan minimal satu data KOL!");
            return;
        }

        // Loop Validasi Per Item
        $(".kol-item-card").each(function(index) {
            const itemNum = index + 1;
            const $card = $(this);

            const kolId = $card.find('select[name="kol_id[]"]').val();
            const folIG = $card.find('input[name="follower_ig[]"]').val();
            const folTT = $card.find('input[name="follower_tt[]"]').val();
            const rateIG = $card.find('input[name="rate_card_ig[]"]').val();
            const rateTT = $card.find('input[name="rate_card_tt[]"]').val();

            // for (let i = 1; i <= 5; i++) {
            //     console.log(`IG#${itemNum} konten_${i}:`, `"${$card.find(`input[name="konten_${i}_ig[]"]`).val()}"`);
            // }



            // 1. Cek KOL & Follower
            if (!kolId) {
                isValid = false;
                errorMessage = `Silakan pilih KOL pada <b>Data KOL #${itemNum}</b>.`;
                return false;
            }

            if (!folIG || !folTT) {
                isValid = false;
                errorMessage = `Mohon isi Followers (IG atau TikTok) pada <b>Data KOL #${itemNum}</b>.`;
                return false;
            }

            // 2. Cek Rate Card (Salah satu wajib)
            if (rateIG == "" || rateTT == "") {
                isValid = false;
                errorMessage = `Mohon isi setidaknya satu Rate Card (IG atau TikTok) pada <b>Data KOL #${itemNum}</b>.`;
                return false;
            }

            // 3. Validasi Views IG (Jika Rate Card IG diisi, Views IG Wajib)
            if (rateIG !== "") {
                let hasIgView = false;
                for (let i = 1; i <= 5; i++) {
                    if ($card.find(`input[name="konten_${i}_ig[]"]`).val() !== "") {
                        hasIgView = true;
                        break;
                    }
                }
                if (!hasIgView) {
                    isValid = false;
                    errorMessage = `Anda mengisi Rate Card IG pada <b>Data KOL #${itemNum}</b>, mohon isi minimal satu data <b>Views Instagram</b>.`;
                    return false;
                }
            }

            // 4. Validasi Views TikTok (Jika Rate Card TT diisi, Views TT Wajib)
            if (rateTT !== "") {
                let hasTtView = false;
                for (let i = 1; i <= 5; i++) {
                    if ($card.find(`input[name="konten_${i}_tt[]"]`).val() !== "") {
                        hasTtView = true;
                        break;
                    }
                }
                if (!hasTtView) {
                    isValid = false;
                    errorMessage = `Anda mengisi Rate Card TikTok pada <b>Data KOL #${itemNum}</b>, mohon isi minimal satu data <b>Views TikTok</b>.`;
                    return false;
                }
            }
        });

        if (!isValid) {
            showValidasi(errorMessage);
            return;
        }

        // --- 2. PREPARE DATA ---
        let formData = new FormData();
        formData.append("campaign_id", $("#kol_campaign_id").val());

        $('select[name="kol_id[]"]').each(function() {
            formData.append('kol_id[]', $(this).val());
        });

        // Helper Clean & Append
        const cleanAndAppend = (selector) => {
            $(selector).each(function() {
                let cleanVal = $(this).val().replace(/\D/g, '') || 0;
                formData.append($(this).attr('name'), cleanVal);
            });
        };

        cleanAndAppend('input[name="follower_ig[]"]');
        cleanAndAppend('input[name="follower_tt[]"]');

        cleanAndAppend('input[name="rate_card_ig[]"]');
        cleanAndAppend('input[name="rate_card_tt[]"]');

        for (let i = 1; i <= 5; i++) {
            cleanAndAppend(`input[name="konten_${i}_ig[]"]`);
            cleanAndAppend(`input[name="konten_${i}_tt[]"]`);
        }

        // Files
        uploadedKOLFiles.forEach(f => formData.append("uploaded_files[]", f));

        // --- 3. AJAX SUBMIT ---
        $.ajax({
            url: baseUrl + "/save_riset_kol",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    $("#modalRisetKOL").modal("hide");
                    showSuccess('Data Riset KOL berhasil disimpan!');
                    loadKanbanData(3);
                } else {
                    $.alert({
                        title: 'Error',
                        content: res.message || 'Gagal menyimpan data.',
                        type: 'red'
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $.alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    });

    // REVIEW LOGIC (Render Grid)
    // --- FUNGSI LOAD DATA REVIEW RISET KOL (UPDATED) ---
    function loadReviewRisetKOL(campaign_id) {
        $("#rvk_items_container").empty();
        $("#rvk_files_list").empty();
        $("#approve_kol_note").val('');
        $("#rvk_campaign_name").text('Loading...');
        $("#rvk_naskah_final").html('-');

        $.ajax({
            url: baseUrl + "/get_review_riset_kol_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    const d = res.data;
                    const items = res.items;

                    $("#rvk_hidden_campaign_id").val(campaign_id);
                    $("#rvk_hidden_riset_id").val(d.riset_kol_id);
                    $("#rvk_campaign_name").text(d.campaign_name);
                    $("#rvk_deadline").text(d.deadline_riset || d.end_date);
                    $("#rvk_hist_big_idea").text(d.big_idea);
                    $("#rvk_hist_goals").text(d.goals);
                    $("#rvk_hist_script_note").text(d.script_note);
                    $("#rvk_timeline").text((d.start_date || '') + ' - ' + (d.end_date || ''));
                    $("#rvk_description").html(d.description || '-');
                    $("#rvk_hist_riset_report").html(d.riset_report || '-');
                    $("#rvk_hist_trend").html(d.trend_analysis || '-');

                    // Influencer/Mediagram Info
                    renderInfluencerInfo(res.influencer_ref, "#rvk_influencer_container");

                    let campLinks = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                    renderLinks(campLinks, "#rvk_campaign_links");

                    let campFiles = [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean);
                    let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/brief/";
                    renderFiles(campFiles, "#rvk_campaign_files", campPath);

                    renderLinks(d.r_link, "#rvk_hist_riset_links");
                    let risetPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/riset_spv/";
                    renderFiles(d.r_file, "#rvk_hist_riset_files", risetPath);

                    renderPriority(d.priority, "#rvk_priority");
                    renderPlacement(d.placement, "#rvk_placement");

                    renderPics(res.pics, "#rvk_pics");
                    $("#rvk_naskah_final").html(d.naskah_final || '<span class="text-muted">No Script</span>');
                    if (d.note_approve) $("#approve_kol_note").val(d.note_approve);

                    showDeadline(d.deadline, d.company_id, 'deadline_budgeting');

                    // --- RENDER GRID ITEMS (DENGAN DETAIL VIEWS) ---
                    if (items && items.length > 0) {
                        items.forEach(item => {
                            let cpvIG = calculateCPV(item, 'ig');
                            let cpvTT = calculateCPV(item, 'tt');

                            // Generate Badges Views IG
                            let viewsIG = '';
                            for (let i = 1; i <= 5; i++) {
                                let v = parseInt(item['konten_' + i + '_ig']) || 0;
                                if (v > 0) viewsIG += `<span class="badge bg-light text-dark border me-1">${formatNumberDisplay(v)}</span>`;
                            }

                            // Generate Badges Views TT
                            let viewsTT = '';
                            for (let i = 1; i <= 5; i++) {
                                let v = parseInt(item['konten_' + i + '_tt']) || 0;
                                if (v > 0) viewsTT += `<span class="badge bg-light text-dark border me-1">${formatNumberDisplay(v)}</span>`;
                            }

                            let html = `
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-white fw-bold d-flex justify-content-between">
                                        <span>${item.kol_nama || '-'}</span>
                                        <small class="text-muted fw-normal">${item.kol_akun || ''}</small>
                                    </div>
                                    <div class="card-body small">                                        
                                        <div class="border-bottom pb-2 mb-2">
                                            <div class="d-flex justify-content-between fw-bold text-danger mb-1">
                                                <span><i class="bi bi-instagram"></i> Rate</span> <span>${formatCurrencyDisplay(item.rate_card_ig)}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold text-info mb-1">
                                                <span><i class="bi bi-people"></i> Followers</span> <span>${formatNumberDisplay(item.follower_ig) || '-'}</span>
                                            </div>
                                            <div class="mb-2 text-muted" style="font-size:11px;">Views: ${viewsIG || '-'}</div>
                                            <div class="d-flex justify-content-between text-muted bg-light p-1 rounded">
                                                <span>CPV Est.</span> <span>${cpvIG}</span>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="d-flex justify-content-between fw-bold text-dark mb-1">
                                                <span><i class="bi bi-tiktok"></i> Rate</span> <span>${formatCurrencyDisplay(item.rate_card_tt)}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold text-info mb-1">
                                                <span><i class="bi bi-people"></i> Followers</span> <span>${formatNumberDisplay(item.follower_tt) || '-'}</span>
                                            </div>
                                            <div class="mb-2 text-muted" style="font-size:11px;">Views: ${viewsTT || '-'}</div>
                                            <div class="d-flex justify-content-between text-muted bg-light p-1 rounded">
                                                <span>CPV Est.</span> <span>${cpvTT}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            $("#rvk_items_container").append(html);
                        });
                    } else {
                        $("#rvk_items_container").html('<div class="col-12 text-center text-muted p-3">Belum ada data KOL.</div>');
                    }

                    if (res.files && Array.isArray(res.files)) {
                        // Ambil hanya nama file
                        const fileNames = res.files.map(f => f.name);
                        let risetPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.id + "/riset_kol/";
                        renderFiles(fileNames, "#rvk_files_list", risetPath);
                    }
                }
            }
        });
    }

    function calculateCPV(item, type) {
        let total = 0,
            count = 0;
        for (let i = 1; i <= 5; i++) {
            let val = parseInt(item['konten_' + i + '_' + type]);
            if (val > 0) {
                total += val;
                count++;
            }
        }
        let rate = parseInt(item['rate_card_' + type]);
        if (count > 0 && rate > 0) {
            let avg = total / count;
            return formatCurrencyDisplay(Math.round(rate / avg));
        }
        return '-';
    }

    // --- TOMBOL REJECT RISET KOL (Kembali ke In Progress) ---
    $("#btnRejectRisetKOL").click(function() {
        const id = $("#rvk_hidden_campaign_id").val();
        $.confirm({
            title: 'Revisi Riset KOL',
            content: 'Kembalikan status ke <b>In Progress</b>?',
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'Ya, Kembalikan',
                    btnClass: 'btn-warning',
                    action: function() {
                        sendNotifReject(id, 3);
                        // Update Progress: ID, Tab 3, Status 10 (In Progress), Old 11
                        updateProgressBackend(id, 3, 10, 11);
                        $("#modalReviewRisetKOL").modal("hide");
                        loadKanbanData(3);
                        $.alert({
                            title: 'Revisi!',
                            content: 'Task dikembalikan ke In Progress.',
                            type: 'orange',
                            icon: 'fa fa-exclamation-triangle',
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });

    // --- TOMBOL APPROVE RISET KOL ---
    $("#btnApproveRisetKOL").click(function() {
        const cid = $("#rvk_hidden_campaign_id").val();
        const rid = $("#rvk_hidden_riset_id").val();
        const note = $.trim($("#approve_kol_note").val());
        const pic = $('#picSelectReviewKOL').val(); // Mengambil array dari SlimSelect
        const deadline = $("#deadline_budgeting").val();


        if (note === "") {
            showValidasi("Mohon isi <b>Catatan Approval</b>!");
            return;
        }

        if (deadline === "") {
            showValidasi("Mohon isi <b>Deadline</b> untuk tahap selanjutnya!");
            return;
        }

        if (!pic || pic.length === 0) {
            showValidasi("Mohon pilih <b>Next PIC</b> untuk tahap Budgeting!");
            return;
        }

        // Convert array pic menjadi string "1,2,3"
        const listPic = pic.join(",");

        // --- 2. KONFIRMASI & AJAX ---
        $.confirm({
            title: 'Konfirmasi Approval',
            content: 'Setujui Riset KOL ini? Task akan lanjut ke tahap <b>Budgeting</b>.',
            type: 'blue',
            buttons: {
                confirm: {
                    text: 'Ya, Approve',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.ajax({
                            url: baseUrl + "/approve_riset_kol",
                            type: "POST",
                            data: {
                                campaign_id: cid,
                                riset_id: rid,
                                note: note,
                                pic: listPic,
                                deadline_budgeting: deadline
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.status) {
                                    $("#modalReviewRisetKOL").modal("hide");

                                    sendNotifApprove(cid, 4);
                                    $.confirm({
                                        title: 'Berhasil!',
                                        content: res.message,
                                        type: 'green',
                                        icon: 'fa fa-check',
                                        buttons: {
                                            ok: {
                                                action: function() {
                                                    // Reload Tab 3 (Riset KOL)
                                                    loadKanbanData(3);
                                                    // Optional: Reload Tab 4 (Budgeting) juga agar terlihat task barunya
                                                    // loadKanbanData(4); 
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        title: 'Error',
                                        content: res.message,
                                        type: 'red'
                                    });
                                }
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>

<!-- budgeting -->
<script>
    let uploadedBudgetFile = null;
    let dzBudget;
    let masterEafData = null;
    let slimKeperluan;
    let slimPengaju;
    let slimProject;

    // Dropzone
    dzBudget = new Dropzone("#dropzoneBudget", {
        url: "<?= base_url('marcom/upload_budgeting_temp'); ?>",
        maxFiles: 1,
        acceptedFiles: ".pdf,.jpg,.jpeg,.png",
        addRemoveLinks: true,
        dictRemoveFile: "<i class='fa fa-trash'></i>",
        init: function() {
            this.on("success", function(file, response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status) uploadedBudgetFile = res.filename;
                } catch (e) {}
            });
            this.on("removedfile", function(file) {
                uploadedBudgetFile = null;
            });
            this.on("addedfile", function() {
                if (this.files[1] != null) {
                    this.removeFile(this.files[0]);
                }
            });
        }
    });

    function loadBudgetingDetail(campaign_id, callback = null) {
        $("#bg_campaign_id").val(campaign_id);

        // Reset Inputs
        clearElements([{
                id: "#bg_nama_penerima",
                action: "val"
            },
            {
                id: "#bg_nama_bank",
                action: "val"
            },
            {
                id: "#bg_rekening",
                action: "val"
            },
            {
                id: "#bg_keperluan",
                action: "val"
            },
            {
                id: "#bg_note",
                action: "val"
            },
            {
                id: "#bg_total",
                action: "val"
            },

            {
                id: "#bg_pengaju",
                action: "val"
            },
            {
                id: "#bg_kategori",
                action: "val"
            },
            {
                id: "#bg_tipe_bayar",
                action: "val"
            },
            {
                id: "#bg_company",
                action: "val"
            }
        ]);


        dzBudget.removeAllFiles(true);
        uploadedBudgetFile = null;

        if (slimKeperluan) {
            // Jika sudah ada, reset data dan disable dulu
            slimKeperluan.setData([{
                text: '-- Pilih Company & Isi Total --',
                value: ''
            }]);
            slimKeperluan.disable();
            slimKeperluan.setSelected(''); // Clear selection
        } else {
            // Jika belum ada, buat instance baru (Cukup sekali)
            slimKeperluan = new SlimSelect({
                select: '#bg_keperluan',
                settings: {
                    showSearch: true,
                    searchText: 'Cari Keperluan...',
                    placeholderText: '-- Pilih Keperluan --',
                    allowDeselect: true,
                    // PENTING: Render di dalam modal agar search berfungsi
                    contentLocation: document.getElementById('modalBudgeting')
                }
            });
            slimKeperluan.disable(); // Default disabled sampai company dipilih
        }

        if (!masterEafData) {
            $.ajax({
                url: baseUrl + "/get_master_eaf_data",
                dataType: "json",
                success: function(res) {
                    masterEafData = res;
                    populateDropdowns(res);
                    fetchBudgetingData(campaign_id, callback);
                }
            });
        } else {
            // Jika sudah ada cache
            populateDropdowns(masterEafData);
            fetchBudgetingData(campaign_id, callback);
        }
    }

    function populateDropdowns(data) {
        // --- 1. Pengaju ---
        let optP = '<option value="">-- Pilih --</option>';
        data.pengaju.forEach(x => optP += `<option value="${x.user_id}">${x.employee_name}</option>`);
        $("#bg_pengaju").html(optP);

        // Perbaikan: Simpan instance ke variable global & Cek existency
        if (slimPengaju) {
            slimPengaju.destroy(); // Hancurkan instance lama jika ada (untuk refresh option)
        }

        slimPengaju = new SlimSelect({
            select: '#bg_pengaju',
            settings: {
                contentLocation: document.getElementById('modalBudgeting')
            }
        });

        // Kategori
        let optK = '<option value="">-- Pilih Kategori --</option>';
        data.kategori.forEach(x => optK += `<option value="${x.id_kategori}">${x.nama_kategori}</option>`);
        $("#bg_kategori").html(optK);

        // Company
        let optC = '<option value="">-- Pilih Company --</option>';
        data.company.forEach(x => optC += `<option value="${x.company_id}">${x.company_name}</option>`);
        optC += `<option value="2">Raja Sukses Propertindo</option>`;
        $("#bg_company").html(optC);

        let optPj = '<option value="">-- Pilih Project --</option>';
        data.project.forEach(x => optPj += `<option value="${x.id_project}">${x.project}</option>`);
        $("#bg_project").html(optPj);

        // Perbaikan: Simpan instance ke variable global & Cek existency
        if (slimProject) {
            slimProject.destroy(); // Hancurkan instance lama jika ada (untuk refresh option)
        }

        slimProject = new SlimSelect({
            select: '#bg_project',
            settings: {
                contentLocation: document.getElementById('modalBudgeting')
            }
        });
    }

    // --- LOGIC INTERAKSI FORM (MIRIP EAF JS) ---

    // 1. Tipe Pembayaran Change
    $("#bg_tipe_bayar").change(function() {
        let val = $(this).val();
        if (val == 2 || val == 3) { // Transfer (2) atau Giro (3)
            $("#bg_nama_bank, #bg_rekening").prop('disabled', false).prop('required', true);
        } else {
            $("#bg_nama_bank, #bg_rekening").prop('disabled', true).val('');
        }
    });

    // 2. Enable Company jika Total diisi
    $("#bg_total").on('input', function() {
        let val = $(this).val();
        if (val != "") {
            $("#bg_company").prop('disabled', false);
        } else {
            $("#bg_company").prop('disabled', true).val('');
            $("#bg_keperluan").prop('disabled', true).html('<option value="">-- Isi Total & Pilih Company --</option>');
        }
    });

    // 3. Load Nama Keperluan saat Company dipilih
    $("#bg_company").change(function() {
        let companyId = $(this).val();
        let nominal = $("#bg_total").val();

        if (companyId == 2) {
            $('#bg_project_container').show();
        } else {
            $('#bg_project_container').hide();
        }

        // Tampilkan Loading di SlimSelect
        if (slimKeperluan) {
            slimKeperluan.setData([{
                text: 'Loading data...',
                value: ''
            }]);
            slimKeperluan.disable();
        }

        if (companyId && nominal) {
            $("#bg_keperluan").prop('disabled', false);

            $.ajax({
                url: baseUrl + "/get_jenis_biaya_eaf",
                type: "POST",
                data: {
                    company_id: companyId,
                    nominal: nominal
                },
                dataType: "json",
                success: function(res) {
                    let options = [];

                    // Format Data untuk SlimSelect
                    if (Array.isArray(res) && res.length > 0) {
                        options = res.map(item => {
                            // Value panjang untuk metadata
                            let val = `${item.id_jenis}|${item.id_biaya}|${item.jenis}|${item.id_user_approval}|${item.id_tipe_biaya}|${item.budget}|||${item.id_user_verified}|${item.ba}`;

                            return {
                                text: `${item.jenis} (Sisa: ${item.budget == 'Unlimited' ? 'Unlimited' : formatNumberDisplay(item.budget)})`,
                                value: val
                            };
                        });
                    }

                    // Tambahkan Placeholder (Wajib agar user dipaksa memilih)
                    options.unshift({
                        text: '-- Pilih Keperluan --',
                        value: '',
                        placeholder: true // Ini penting agar tidak terpilih otomatis sebagai value valid
                    });

                    // Update SlimSelect
                    if (slimKeperluan) {
                        slimKeperluan.setData(options);
                        slimKeperluan.enable();
                        // Reset selection agar user harus klik pilih
                        slimKeperluan.setSelected('');
                    }
                },
                error: function(err) {
                    console.error("Gagal load keperluan", err);
                    if (slimKeperluan) slimKeperluan.setData([{
                        text: 'Gagal memuat data',
                        value: ''
                    }]);
                }
            });
        } else {
            // Reset jika company/nominal dihapus
            if (slimKeperluan) {
                slimKeperluan.setData([{
                    text: '-- Isi Total & Pilih Company --',
                    value: ''
                }]);
                slimKeperluan.disable();
            }
        }
    });

    function fetchBudgetingData(campaign_id, callback = null) {
        $.ajax({
            url: baseUrl + "/get_budgeting_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    const d = res.data;
                    $("#bg_campaign_name").text(d.campaign_name);
                    $("#bg_timeline").text((d.start_date || '') + ' - ' + (d.end_date || ''));
                    $("#bg_goals").text(d.goals || '-');
                    $("#bg_big_idea").text(d.big_idea || '-');

                    renderPriority(d.priority, "#bg_priority");

                    // Placement Badge
                    renderPlacement(d.placement, "#bg_placement");

                    // Render PIC Budgeting
                    renderPics(res.pics, "#bg_pics");

                    $('#bg_deadline').text(d.deadline || d.end_date);

                    let campLinks = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                    renderLinks(campLinks, "#bg_camp_links");

                    let campFiles = [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean);
                    let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/brief/";
                    renderFiles(campFiles, "#bg_camp_files", campPath);

                    renderInfluencerInfo(res.influencer_ref, "#bg_influencer_container");

                    // 2. ISI HISTORY RISET SPV
                    $("#bg_riset_report").html(d.riset_report || '-');
                    $("#bg_description").html(d.description || '-');
                    $("#bg_trend_analysis").html(d.trend_analysis || '-');
                    $("#bg_riset_note").text(d.riset_note || '-');

                    renderLinks(d.riset_link, "#bg_riset_links");

                    // 2. Render File (Support Banyak File)
                    // Data d.riset_file otomatis akan di-split oleh helper renderFiles
                    let risetSpvPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/riset_spv/";
                    renderFiles(d.riset_file, "#bg_riset_files", risetSpvPath);

                    // 3. ISI HISTORY SCRIPT
                    $("#bg_naskah_final").html(d.naskah_final || '<span class="text-muted">Belum ada naskah final.</span>');
                    let noteHtml = d.script_note ?
                        d.script_note :
                        '<span class="text-muted opacity-50">Tidak ada catatan approval.</span>';
                    $("#bg_script_note").html(noteHtml);

                    let noteKolHtml = d.kol_note ?
                        d.kol_note :
                        '<span class="text-muted opacity-50">Tidak ada catatan approval.</span>';
                    $("#bg_kol_note").html(noteKolHtml);

                    // RENDER KOL REFERENCE (FULL DETAIL)
                    $("#bg_kol_container").empty();
                    if (res.kol_items && res.kol_items.length > 0) {
                        res.kol_items.forEach(item => {
                            // Reuse Logic Display Card dari Review Riset KOL
                            // Agar tampilan konsisten (Views badges, Rate, CPV)

                            let cpvIG = calculateCPV(item, 'ig');
                            let cpvTT = calculateCPV(item, 'tt');

                            let viewsIG = '';
                            for (let i = 1; i <= 5; i++) {
                                let v = parseInt(item['konten_' + i + '_ig']) || 0;
                                if (v > 0) viewsIG += `<span class="badge bg-light text-dark border me-1">${formatNumberDisplay(v)}</span>`;
                            }

                            let viewsTT = '';
                            for (let i = 1; i <= 5; i++) {
                                let v = parseInt(item['konten_' + i + '_tt']) || 0;
                                if (v > 0) viewsTT += `<span class="badge bg-light text-dark border me-1">${formatNumberDisplay(v)}</span>`;
                            }

                            let html = `
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                                        <span class="text-primary">${item.kol_nama || '-'}</span>
                                    </div>
                                    <div class="card-body small p-2">
                                        <div class="border-bottom pb-2 mb-2">
                                            <div class="d-flex justify-content-between fw-bold text-danger mb-1 align-items-center">
                                                <span><i class="bi bi-instagram"></i> Rate</span> 
                                                <span class="fs-6">${formatCurrencyDisplay(item.rate_card_ig)}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold text-info mb-1 align-items-center">
                                                <span><i class="bi bi-people"></i> Followers</span> 
                                                <span class="fs-6">${formatNumberDisplay(item.follower_ig)}</span>
                                            </div>
                                            <div class="mb-1 text-muted d-flex flex-wrap gap-1" style="font-size:10px;">
                                                <span class="me-1">Views:</span> ${viewsIG || '-'}
                                            </div>
                                            <div class="d-flex justify-content-between text-muted bg-light p-1 rounded mt-1">
                                                <span>CPV Est.</span> <span>${cpvIG}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex justify-content-between fw-bold text-dark mb-1 align-items-center">
                                                <span><i class="bi bi-tiktok"></i> Rate</span> 
                                                <span class="fs-6">${formatCurrencyDisplay(item.rate_card_tt)}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold text-info mb-1 align-items-center">
                                                <span><i class="bi bi-people"></i> Followers</span> 
                                                <span class="fs-6">${formatNumberDisplay(item.follower_tt)}</span>
                                            </div>
                                            <div class="mb-1 text-muted d-flex flex-wrap gap-1" style="font-size:10px;">
                                                <span class="me-1">Views:</span> ${viewsTT || '-'}
                                            </div>
                                            <div class="d-flex justify-content-between text-muted bg-light p-1 rounded mt-1">
                                                <span>CPV Est.</span> <span>${cpvTT}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            $("#bg_kol_container").append(html);
                        });
                    } else {
                        $("#bg_kol_container").html('<div class="col-12 text-center text-muted p-3">Tidak ada data KOL approved.</div>');
                    }

                    let risetKolPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/riset_kol/";
                    renderFiles(d.files_kol, "#bg_kol_files", risetKolPath);

                    // Isi Form Edit
                    if (d.nama_penerima) {
                        $("#bg_nama_penerima").val(d.nama_penerima);
                        if (slimPengaju) {
                            slimPengaju.setSelected(d.yang_mengajukan); // Gunakan API SlimSelect
                        } else {
                            $("#bg_pengaju").val(d.yang_mengajukan); // Fallback
                        }
                        $("#bg_kategori").val(d.kategori_id);
                        $("#bg_tipe_bayar").val(d.tipe_pembayaran).trigger('change');
                        $("#bg_nama_bank").val(d.nama_bank);
                        $("#bg_rekening").val(d.nomor_rekening);
                        $("#bg_total").val(formatCurrencyDisplay(d.total_budget));
                        $("#bg_note").val(d.note);

                        // Trigger logic company & keperluan
                        $("#bg_company").prop('disabled', false).val(d.company_id);
                        if (d.company_id == 2) {
                            $('#bg_project_container').show();
                            $("#bg_project").val(d.id_project);
                            slimProject.setSelected(d.id_project);
                        } else {
                            $('#bg_project_container').hide();
                        }

                        // Load Keperluan Manual agar value terpilih
                        $.ajax({
                            url: baseUrl + "/get_jenis_biaya_eaf",
                            type: "POST",
                            data: {
                                company_id: d.company_id,
                                nominal: d.total_budget
                            },
                            dataType: "json",
                            success: function(r) {
                                // Format Data
                                var options = r.map(item => {
                                    let val = `${item.id_jenis}|${item.id_biaya}|${item.jenis}|${item.id_user_approval}|${item.id_tipe_biaya}|${item.budget}|||${item.id_user_verified}|${item.ba}`;

                                    // Cek apakah ini opsi yang terpilih (based on id_jenis yang disimpan di eaf_id_jenis)
                                    let isSelected = (item.id_jenis == d.eaf_id_jenis);

                                    return {
                                        text: `${item.jenis} (Sisa: ${formatNumberDisplay(item.budget)})`,
                                        value: val,
                                        selected: isSelected // SlimSelect v2 auto select
                                    };
                                });

                                options.unshift({
                                    text: '-- Pilih Keperluan --',
                                    value: '',
                                    placeholder: true
                                });

                                // Update SlimSelect
                                if (slimKeperluan) {
                                    slimKeperluan.setData(options);
                                    slimKeperluan.enable();
                                }
                            }
                        });


                        if (d.file_lampiran && res.file_url) {
                            let fName = d.file_lampiran; // Nama file dari DB (e.g. 8e05...png)
                            let fUrl = res.file_url; // URL lengkap (e.g. https://.../8e05...png)

                            // 1. Set Global Variable agar tidak dianggap kosong saat simpan
                            uploadedBudgetFile = fName;

                            // 2. Buat Mock File Object
                            let mockFile = {
                                name: fName,
                                size: 12345,
                                type: 'image/png', // Default type, dropzone akan deteksi dari ekstensi
                                status: Dropzone.ADDED,
                                url: fUrl
                            };

                            // 3. Panggil Event Dropzone
                            dzBudget.emit("addedfile", mockFile);

                            // 4. Tampilkan Thumbnail (Jika Gambar)
                            if (fName.match(/\.(jpg|jpeg|png|gif)$/i)) {
                                dzBudget.emit("thumbnail", mockFile, fUrl);
                            } else {
                                // Jika PDF, Dropzone pakai icon default
                                dzBudget.emit("thumbnail", mockFile, null);
                            }

                            // 5. Complete
                            dzBudget.emit("complete", mockFile);

                            // 6. PENTING: Masukkan ke array internal dropzone agar dihitung sebagai 1 file
                            // Ini mencegah user upload file ke-2 jika maxFiles: 1
                            dzBudget.files.push(mockFile);
                        }
                    }
                }
                if (callback) callback();
            }
        });
    }

    // --- TOMBOL SIMPAN BUDGETING ---
    $("#btnSaveBudget").click(function() {



        let keperluan = $("#bg_keperluan").val()



        // --- 1. VALIDASI INPUT WAJIB ---
        if (!$("#bg_nama_penerima").val()) {
            showValidasi("<b>Nama Penerima</b> wajib diisi.");
            return;
        }
        if (!$("#bg_pengaju").val()) {
            showValidasi("Silakan pilih <b>Yang Mengajukan</b>.");
            return;
        }
        if (!$("#bg_kategori").val()) {
            showValidasi("Silakan pilih <b>Kategori</b>.");
            return;
        }

        // Validasi Tipe Pembayaran
        let tipe = $("#bg_tipe_bayar").val();
        if (!tipe) {
            showValidasi("Silakan pilih <b>Tipe Pembayaran</b>.");
            return;
        }
        // Jika Transfer (2) atau Giro (3), Bank & Rekening Wajib
        if ((tipe == 2 || tipe == 3) && (!$("#bg_nama_bank").val() || !$("#bg_rekening").val())) {
            showValidasi("Untuk Transfer/Giro, <b>Nama Bank</b> dan <b>No Rekening</b> wajib diisi.");
            return;
        }

        // Validasi Detail Keperluan
        if (!$("#bg_total").val()) {
            showValidasi("<b>Total Budget</b> wajib diisi.");
            return;
        }
        if (!$("#bg_company").val()) {
            showValidasi("Silakan pilih <b>Company</b>.");
            return;
        }

        if ($("#bg_company").val() == 2 && !$("#bg_project").val()) {
            showValidasi("Silakan pilih <b>Project</b>.");
            return;
        }

        if (!$("#bg_keperluan").val()) {
            showValidasi("Silakan pilih <b>Nama Keperluan (EAF)</b>.");
            return;
        }

        // --- 2. PERSIAPAN DATA ---
        let formData = new FormData();
        formData.append("campaign_id", $("#bg_campaign_id").val());
        formData.append("nama_penerima", $("#bg_nama_penerima").val());
        formData.append("yang_mengajukan", $("#bg_pengaju").val());
        formData.append("kategori_id", $("#bg_kategori").val());
        formData.append("tipe_pembayaran", $("#bg_tipe_bayar").val());
        formData.append("nama_bank", $("#bg_nama_bank").val());
        formData.append("nomor_rekening", $("#bg_rekening").val());

        // Detail Keperluan
        formData.append("total_budget", $("#bg_total").val());
        formData.append("company_id", $("#bg_company").val());
        formData.append("project_id", $("#bg_project").val());

        // Value dari select ini berisi string panjang "id|nama|user..." yang akan di-explode controller
        formData.append("nama_keperluan", keperluan);

        formData.append("note", $("#bg_note").val());

        if (uploadedBudgetFile) {
            formData.append("uploaded_file_budget", uploadedBudgetFile);
        }

        // --- 3. AJAX REQUEST ---
        $.ajax({
            url: baseUrl + "/save_budgeting",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $("#btnSaveBudget").prop('disabled', true).text('Menyimpan...');
            },
            success: function(res) {
                if (res.status) {
                    $("#modalBudgeting").modal("hide");

                    $.confirm({
                        title: 'Berhasil!',
                        content: res.message,
                        type: 'green',
                        icon: 'fa fa-check',
                        buttons: {
                            ok: {
                                action: function() {
                                    loadKanbanData(4); // Reload Tab 4 (Budgeting)
                                }
                            }
                        }
                    });
                } else {
                    $.alert({
                        title: 'Gagal',
                        content: 'Gagal menyimpan data.',
                        type: 'red'
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $.alert('Terjadi kesalahan server.');
            },
            complete: function() {
                $("#btnSaveBudget").prop('disabled', false).text('Simpan Pengajuan');
            }
        });
    });

    // --- FUNGSI LOAD REVIEW BUDGET (FULL CODE UPDATED) ---
    function loadReviewBudget(campaign_id) {
        // Reset UI
        $("#rvb_kol_container").empty();
        $("#rvb_file_container").html('<span class="text-muted small">Tidak ada lampiran.</span>');
        $("#approve_budget_note").val('');
        $("#rvb_campaign_name").text('Loading...');

        // Reset History Alert
        $("#rvb_approval_history").hide().empty();

        $.ajax({
            url: baseUrl + "/get_review_budget_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    const d = res.data;

                    // --- 1. META DATA & HEADER ---
                    $("#rvb_hidden_campaign_id").val(d.campaign_id);
                    $("#rvb_hidden_budget_id").val(d.id);

                    $('#approve_budget_note').val(d.note_approve);

                    $("#rvb_campaign_name").text(d.campaign_name);
                    $("#rvb_deadline").text(d.deadline || d.end_date);
                    $("#rvb_hist_goals").text(d.goals);
                    $("#rvb_hist_big_idea").text(d.big_idea);
                    $("#rvb_hist_description").html(d.description);
                    $("#rvb_timeline").text((d.start_date || '') + ' - ' + (d.end_date || ''));
                    renderPriority(d.priority, "#rvb_priority");
                    renderPlacement(d.placement, "#rvb_placement");

                    showDeadline(d.deadline_shooting, d.company_id, 'deadline_shooting');

                    // PIC
                    renderPics(res.pics, "#rvb_pics");

                    let campLinks = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                    renderLinks(campLinks, "#rvb_camp_links"); // Menggunakan helper renderLinks

                    let campFiles = [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean);
                    let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/brief/";
                    renderFiles(campFiles, "#rvb_camp_files", campPath); // Menggunakan helper renderFiles

                    renderInfluencerInfo(res.influencer_ref, "#rvb_influencer_container");

                    $("#rvb_riset_report").html(d.riset_report || '-');
                    $("#rvb_description").html(d.description || '-');
                    $("#rvb_trend_analysis").html(d.trend_analysis || '-');
                    $("#rvb_riset_note").text(d.riset_note || '-');

                    renderLinks(d.riset_link, "#rvb_riset_links");

                    // 2. Render File (Support Banyak File)
                    // Data d.riset_file otomatis akan di-split oleh helper renderFiles
                    let risetSpvPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/riset_spv/";
                    renderFiles(d.riset_file, "#rvb_riset_files", risetSpvPath);

                    // 3. ISI HISTORY SCRIPT
                    $("#rvb_naskah_final").html(d.naskah_final || '<span class="text-muted">Belum ada naskah final.</span>');
                    let noteHtml = d.script_note ?
                        d.script_note :
                        '<span class="text-muted opacity-50">Tidak ada catatan approval.</span>';
                    $("#rvb_script_note").html(noteHtml);

                    let noteKolHtml = d.kol_note ?
                        d.kol_note :
                        '<span class="text-muted opacity-50">Tidak ada catatan approval.</span>';
                    $("#rvb_kol_note").html(noteKolHtml);

                    // --- 2. RENDER REFERENSI KOL (FULL GRID) ---
                    $("#rvb_kol_container").empty();
                    if (res.kol_items && res.kol_items.length > 0) {
                        res.kol_items.forEach(item => {
                            // Hitung CPV (Helper Function)
                            let cpvIG = calculateCPV(item, 'ig');
                            let cpvTT = calculateCPV(item, 'tt');

                            // Generate Badges Views IG
                            let viewsIG = '';
                            for (let i = 1; i <= 5; i++) {
                                let v = parseInt(item['konten_' + i + '_ig']) || 0;
                                if (v > 0) viewsIG += `<span class="badge bg-light text-dark border me-1">${formatNumberDisplay(v)}</span>`;
                            }

                            // Generate Badges Views TT
                            let viewsTT = '';
                            for (let i = 1; i <= 5; i++) {
                                let v = parseInt(item['konten_' + i + '_tt']) || 0;
                                if (v > 0) viewsTT += `<span class="badge bg-light text-dark border me-1">${formatNumberDisplay(v)}</span>`;
                            }

                            let html = `
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                                        <span class="text-primary">${item.kol_nama || '-'}</span>
                                    </div>
                                    <div class="card-body small p-2">
                                        <div class="border-bottom pb-2 mb-2">
                                            <div class="d-flex justify-content-between fw-bold text-danger mb-1 align-items-center">
                                                <span><i class="bi bi-instagram"></i> Rate</span> 
                                                <span class="fs-6">${formatCurrencyDisplay(item.rate_card_ig)}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold text-info mb-1 align-items-center">
                                                <span><i class="bi bi-people"></i> Followers</span> 
                                                <span class="fs-6">${formatNumberDisplay(item.follower_ig)}</span>
                                            </div>
                                            <div class="mb-1 text-muted d-flex flex-wrap gap-1" style="font-size:10px;">
                                                <span class="me-1">Views:</span> ${viewsIG || '-'}
                                            </div>
                                            <div class="d-flex justify-content-between text-muted bg-light p-1 rounded mt-1">
                                                <span>CPV Est.</span> <span>${cpvIG}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex justify-content-between fw-bold text-dark mb-1 align-items-center">
                                                <span><i class="bi bi-tiktok"></i> Rate</span> 
                                                <span class="fs-6">${formatCurrencyDisplay(item.rate_card_tt)}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold text-info mb-1 align-items-center">
                                                <span><i class="bi bi-people"></i> Followers</span> 
                                                <span class="fs-6">${formatNumberDisplay(item.follower_tt)}</span>
                                            </div>
                                            <div class="mb-1 text-muted d-flex flex-wrap gap-1" style="font-size:10px;">
                                                <span class="me-1">Views:</span> ${viewsTT || '-'}
                                            </div>
                                            <div class="d-flex justify-content-between text-muted bg-light p-1 rounded mt-1">
                                                <span>CPV Est.</span> <span>${cpvTT}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            $("#rvb_kol_container").append(html);
                        });
                    } else {
                        $("#rvb_kol_container").html('<div class="col-12 text-center text-muted p-2">Tidak ada referensi KOL.</div>');
                    }

                    let risetKolPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + campaign_id + "/riset_kol/";
                    renderFiles(d.files_kol, "#rvb_kol_files", risetKolPath);

                    // --- 3. RENDER CONTENT BUDGETING ---
                    $("#rvb_penerima").text(d.nama_penerima || '-');
                    $("#rvb_pengaju").text(res.nama_pengaju || '-');

                    let kat = d.kategori_id == 17 ? 'Reimbursment' : (d.kategori_id == 18 ? 'Pembawaan' : (d.kategori_id == 19 ? 'LPJ' : 'Pinjaman Karyawan (CR)'));
                    $("#rvb_kategori").text(kat);

                    let tipe = d.tipe_pembayaran == 1 ? 'Tunai' : (d.tipe_pembayaran == 2 ? 'Transfer Bank' : (d.tipe_pembayaran == 3 ? 'Giro' : '-'));
                    $("#rvb_tipe_bayar").text(tipe);

                    $("#rvb_bank").text(d.nama_bank || '-');
                    $("#rvb_rekening").text(d.nomor_rekening || '-');

                    $("#rvb_total").text(formatCurrencyDisplay(d.total_budget));
                    $("#rvb_keperluan").text(d.nama_keperluan || '-');
                    $("#rvb_note").text(d.note || '-');
                    $("#rvb_company").text(d.company_name || '-');
                    $("#rvb_project").text(d.project_name || '-');

                    // --- 4. RENDER FILE ---
                    if (res.file_url) {
                        $("#rvb_file_container").html(`
                            <a href="${res.file_url}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat Lampiran
                            </a>
                        `);
                    }

                    // --- 5. LOGIC HISTORY (JIKA COMPLETED) ---
                    if (d.status >= 16) {
                        let eafNo = d.eaf_ref_no || '-';
                        let approver = res.nama_approver || '-';
                        let dateApp = res.approved_at || '-';

                        let htmlHist = `
                        <div class="alert alert-success border-success d-flex align-items-center shadow-sm">
                            <i class="bi bi-check-circle-fill fs-3 me-3 text-success"></i>
                            <div class="w-100">
                                <h6 class="fw-bold mb-1 text-success">Budgeting Disetujui & Terintegrasi EAF</h6>
                                <div class="row small mt-2">
                                    <div class="col-md-4">
                                        <span class="text-muted d-block">Approved By:</span>
                                        <strong class="text-dark">${approver}</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-muted d-block">Date:</span>
                                        <strong class="text-dark">${dateApp}</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-muted d-block">No. EAF:</span>
                                        <strong class="text-primary">${eafNo}</strong>
                                    </div>
                                </div>
                                ${d.note_approve ? `<div class="mt-2 pt-2 border-top border-success-subtle"><span class="text-muted small fst-italic">Note: "${d.note_approve}"</span></div>` : ''}
                            </div>
                        </div>`;

                        $("#rvb_approval_history").html(htmlHist).show();
                    }

                } else {
                    alert(res.message);
                    $("#modalReviewBudget").modal("hide");
                }
            },
            error: function(err) {
                console.error("Gagal memuat detail budget:", err);
                alert("Gagal memuat detail budget.");
            }
        });
    }

    // --- APPROVE BUDGET (INTEGRASI EAF) ---
    $("#btnApproveBudget").click(function() {
        const cid = $("#rvb_hidden_campaign_id").val();
        const bid = $("#rvb_hidden_budget_id").val();
        const note = $.trim($("#approve_budget_note").val());
        const pic = $('#picSelectReviewBudget').val();
        const deadline = $("#deadline_shooting").val();


        if (note === "") {
            showValidasi("Mohon isi <b>Catatan Approval</b>!");
            return;
        }

        if (deadline === "") {
            showValidasi("Mohon isi <b>Deadline</b> untuk tahap selanjutnya!");
            return;
        }

        if (!pic || pic.length === 0) {
            showValidasi("Mohon pilih <b>Next PIC</b> untuk tahap Shooting!");
            return;
        }

        // Convert array pic menjadi string "1,2,3"
        const listPic = pic.join(",");

        $.confirm({
            title: 'Konfirmasi Final',
            content: 'Apakah Anda yakin menyetujui Budget ini?<br>Data akan <b>dikirim ke EAF System</b> dan status campaign menjadi <b>Completed</b>.',
            type: 'green',
            buttons: {
                confirm: {
                    text: 'Ya, Approve',
                    btnClass: 'btn-success',
                    action: function() {
                        $.ajax({
                            url: baseUrl + "/approve_budget",
                            type: "POST",
                            data: {
                                campaign_id: cid,
                                budget_id: bid,
                                note: note,
                                pic: listPic,
                                deadline_shooting: deadline
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.status) {
                                    $("#modalReviewBudget").modal("hide");
                                    sendNotifApprove(cid, 5);
                                    $.confirm({
                                        title: 'Berhasil!',
                                        content: res.message,
                                        type: 'green',
                                        icon: 'fa fa-check',
                                        buttons: {
                                            ok: {
                                                action: function() {
                                                    loadKanbanData(4);
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        title: 'Error',
                                        content: res.message,
                                        type: 'red'
                                    });
                                }
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });

    // --- TOMBOL REJECT BUDGETING (Kembali ke In Progress) ---
    $("#btnRejectBudget").click(function() {
        const id = $("#rvb_hidden_campaign_id").val();

        $.confirm({
            title: 'Revisi Budgeting',
            content: 'Apakah Anda yakin ingin mengembalikan status ke <b>In Progress</b> untuk direvisi?<br><small class="text-muted">Data inputan tidak akan hilang.</small>',
            type: 'orange',
            icon: 'fa fa-undo',
            buttons: {
                confirm: {
                    text: 'Ya, Kembalikan',
                    btnClass: 'btn-warning',
                    action: function() {
                        sendNotifReject(id, 4);
                        // Logic: ID, Tab 4, Status Baru 14 (In Progress), Status Lama 15
                        updateProgressBackend(id, 4, 14, 15);

                        $("#modalReviewBudget").modal("hide");

                        // Reload Kanban Tab 4
                        loadKanbanData(4);

                        $.alert({
                            title: 'Revisi!',
                            content: 'Task dikembalikan ke In Progress.',
                            type: 'orange',
                            icon: 'fa fa-exclamation-triangle',
                            buttons: {
                                close: {
                                    actions: function() {}
                                }
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>

<!-- Shooting -->
<script>
    let filesShooting = [];
    let dzShooting;


    dzShooting = new Dropzone("#dropzoneShooting", {
        url: "<?= base_url('marcom/upload_temp_files'); ?>",
        maxFiles: 3,
        acceptedFiles: ".pdf,.jpg,.jpeg,.png,.doc,.docx",
        addRemoveLinks: true,
        dictRemoveFile: "<i class='fa fa-trash'></i>",
        init: function() {
            this.on("success", function(file, response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status) {
                        file.serverFileName = res.filename;
                        filesShooting.push(res.filename);
                    }
                } catch (e) {}
            });
            this.on("removedfile", function(file) {
                let name = file.serverFileName || file.name;
                let idx = filesShooting.indexOf(name);
                if (idx !== -1) filesShooting.splice(idx, 1);
            });
        }
    });


    $('#keterangan').summernote({
        height: 150,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });

    function loadShootingDetail(campaign_id) {
        clearElements([
            // text "-"
            {
                id: "#shooting_timeline",
                action: "text"
            },
            {
                id: "#shooting_deadline",
                action: "text"
            },
            {
                id: "#shooting_hist_goals",
                action: "text"
            },
            {
                id: "#shooting_hist_big_idea",
                action: "text"
            },
            {
                id: "#shooting_riset_note",
                action: "text"
            },
            {
                id: "#shooting_script_note",
                action: "text"
            },
            {
                id: "#shooting_kol_note",
                action: "text"
            },
            {
                id: "#shooting_penerima",
                action: "text"
            },
            {
                id: "#shooting_pengaju",
                action: "text"
            },
            {
                id: "#shooting_kategori",
                action: "text"
            },
            {
                id: "#shooting_tipe_bayar",
                action: "text"
            },
            {
                id: "#shooting_bank",
                action: "text"
            },
            {
                id: "#shooting_rekening",
                action: "text"
            },
            {
                id: "#shooting_keperluan",
                action: "text"
            },
            {
                id: "#shooting_note",
                action: "text"
            },
            {
                id: "#shooting_company",
                action: "text"
            },
            {
                id: "#shooting_project",
                action: "text"
            },

            // html "-"
            {
                id: "#shooting_priority",
                action: "html"
            },
            {
                id: "#shooting_placement",
                action: "html"
            },
            {
                id: "#shooting_pics",
                action: "html"
            },
            {
                id: "#shooting_hist_description",
                action: "html"
            },
            {
                id: "#shooting_riset_report",
                action: "html"
            },
            {
                id: "#shooting_trend_analysis",
                action: "html"
            },
            {
                id: "#shooting_naskah_final",
                action: "html"
            },

            // empty
            {
                id: "#shooting_influencer_container",
                action: "empty"
            },
            {
                id: "#shooting_camp_links",
                action: "empty"
            },
            {
                id: "#shooting_camp_files",
                action: "empty"
            },
            {
                id: "#shooting_riset_links",
                action: "empty"
            },
            {
                id: "#shooting_riset_files",
                action: "empty"
            },
            {
                id: "#shooting_kol_container",
                action: "empty"
            },
            {
                id: "#shooting_kol_files",
                action: "empty"
            },
            {
                id: "#shooting_file_container",
                action: "empty"
            },
            {
                id: "#shootingLinkContainer",
                action: "empty"
            },

            // val
            {
                id: "#shooting_campaign_id",
                action: "val"
            },

            // hide + empty
            {
                id: "#shooting_approval_history",
                action: "hideEmpty"
            },

            // special values
            {
                id: "#shooting_campaign_name",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#shooting_total",
                action: "text",
                value: "Rp 0"
            }
        ]);

        dzShooting.removeAllFiles(true);
        filesShooting = [];

        $.ajax({
            url: baseUrl + "/get_shooting_detail",
            type: "POST",
            data: {
                campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (!res.status) {
                    alert(res.message || "Gagal memuat data shooting.");
                    return;
                }

                const d = res.data;

                $("#lokasi").val(d.shooting_lokasi || '');
                $("#shooting_campaign_id").val(d.campaign_id);

                if (d.shooting_output) {
                    const outputArr = d.shooting_output.split(',');
                    outputSelect.setSelected(outputArr);
                } else {
                    outputSelect.setSelected([]);
                }


                if (d.shooting_keterangan) {
                    $('#keterangan').summernote('code', d.shooting_keterangan);
                } else {
                    $('#keterangan').summernote('reset');
                }

                if (d.shooting_link) {
                    d.shooting_link
                        .split(',')
                        .map(l => l.trim())
                        .filter(l => l !== "")
                        .forEach(link => {
                            addShootingLinkInput(link);
                        });
                } else {
                    // optional: tampilkan 1 input kosong
                    addShootingLinkInput();
                }

                if (res.file_url_shooting && res.file_url_shooting.length > 0) {
                    res.file_url_shooting.forEach(f => {
                        filesShooting.push(f.name);

                        let mock = {
                            name: f.name,
                            size: 12345,
                            serverFileName: f.name
                        };

                        dzShooting.emit("addedfile", mock);

                        if (f.name.match(/\.(jpg|jpeg|png|gif)$/i)) {
                            dzShooting.emit("thumbnail", mock, f.url);
                        }

                        dzShooting.emit("complete", mock);
                        dzShooting.files.push(mock);
                    });
                }


                // Header
                $("#shooting_campaign_name").text(d.campaign_name);
                $("#shooting_timeline").text((d.start_date || '-') + ' - ' + (d.end_date || '-'));
                $("#shooting_deadline").text(d.deadline_shooting || d.end_date || '-');
                renderPriority(d.priority, "#shooting_priority");
                renderPlacement(d.placement, "#shooting_placement");
                renderPics(res.pics, "#shooting_pics");

                // Campaign Brief
                renderInfluencerInfo(res.influencer_ref, "#shooting_influencer_container");
                $("#shooting_hist_goals").text(d.goals || '-');
                $("#shooting_hist_big_idea").text(d.big_idea || '-');
                $("#shooting_hist_description").html(d.description || '-');
                let campLinks = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                renderLinks(campLinks, "#shooting_camp_links");
                let campFiles = [
                    d.reference_file,
                    d.reference_file_2,
                    d.reference_file_3
                ].filter(Boolean);

                let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/brief/";
                renderFiles(campFiles, "#shooting_camp_files", campPath);


                // Riset Campaign
                $("#shooting_riset_report").html(d.riset_report || '-');
                $("#shooting_trend_analysis").html(d.trend_analysis || '-');
                $("#shooting_riset_note").text(d.riset_note || '-');
                renderLinks(d.riset_link, "#shooting_riset_links");
                let risetSpvPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/riset_spv/";
                renderFiles(d.riset_file, "#shooting_riset_files", risetSpvPath);

                // Script
                $("#shooting_script_note").text(d.script_note || '-');
                $("#shooting_naskah_final").html(d.naskah_final || '-');

                // Riset KOL
                $("#shooting_kol_note").text(d.kol_note || '-');
                $("#shooting_kol_container").empty();
                if (res.kol_items && res.kol_items.length > 0) {
                    res.kol_items.forEach(item => {
                        let cpvIG = calculateCPV(item, 'ig');
                        let cpvTT = calculateCPV(item, 'tt');
                        let html = `
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                                    <span class="text-primary">${item.kol_nama || '-'}</span>
                                </div>
                                <div class="card-body small p-2">
                                    <div class="border-bottom pb-2 mb-2">
                                        <div class="d-flex justify-content-between fw-bold text-danger mb-1 align-items-center">
                                            <span><i class="bi bi-instagram"></i> Rate</span> 
                                            <span class="fs-6">${formatCurrencyDisplay(item.rate_card_ig)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between fw-bold text-info mb-1 align-items-center">
                                            <span><i class="bi bi-people"></i> Followers</span> 
                                            <span class="fs-6">${formatNumberDisplay(item.follower_ig)}</span>
                                        </div>
                                        <div class="mb-1 text-muted d-flex flex-wrap gap-1" style="font-size:10px;">
                                            <span class="me-1">Views:</span> - 
                                        </div>
                                        <div class="d-flex justify-content-between text-muted bg-light p-1 rounded mt-1">
                                            <span>CPV Est.</span> <span>${cpvIG}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between fw-bold text-dark mb-1 align-items-center">
                                            <span><i class="bi bi-tiktok"></i> Rate</span> 
                                            <span class="fs-6">${formatCurrencyDisplay(item.rate_card_tt)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between fw-bold text-info mb-1 align-items-center">
                                            <span><i class="bi bi-people"></i> Followers</span> 
                                            <span class="fs-6">${formatNumberDisplay(item.follower_tt)}</span>
                                        </div>
                                        <div class="mb-1 text-muted d-flex flex-wrap gap-1" style="font-size:10px;">
                                            <span class="me-1">Views:</span> - 
                                        </div>
                                        <div class="d-flex justify-content-between text-muted bg-light p-1 rounded mt-1">
                                            <span>CPV Est.</span> <span>${cpvTT}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        $("#shooting_kol_container").append(html);
                    });
                } else {
                    $("#shooting_kol_container").html('<div class="col-12 text-center text-muted p-2">Tidak ada referensi KOL.</div>');
                }
                let risetKolPath = baseUrl.replace('/marcom', '') + "uploads/marcom/campaigns/" + d.campaign_id + "/riset_kol/";
                renderFiles(d.files_kol, "#shooting_kol_files", risetKolPath);

                // Budgeting
                $("#shooting_penerima").text(d.nama_penerima || '-');
                $("#shooting_pengaju").text(res.nama_pengaju || '-');
                let kat = d.kategori_id == 17 ? 'Reimbursment' : (d.kategori_id == 18 ? 'Pembawaan' : (d.kategori_id == 19 ? 'LPJ' : 'Pinjaman Karyawan (CR)'));
                $("#shooting_kategori").text(kat);

                let tipe = d.tipe_pembayaran == 1 ? 'Tunai' : (d.tipe_pembayaran == 2 ? 'Transfer Bank' : (d.tipe_pembayaran == 3 ? 'Giro' : '-'));
                $("#shooting_tipe_bayar").text(tipe);
                $("#shooting_bank").text(d.nama_bank || '-');
                $("#shooting_rekening").text(d.nomor_rekening || '-');
                $("#shooting_total").text(formatCurrencyDisplay(d.total_budget));
                $("#shooting_keperluan").text(d.nama_keperluan || '-');
                $("#shooting_note").text(d.note || '-');
                $("#shooting_company").text(d.company_name || '-');
                $("#shooting_project").text(d.project_name || '-');
                if (res.file_url_budget) {
                    $("#shooting_file_container").html(`
                    <a href="${res.file_url_budget}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat Lampiran
                    </a>
                `);
                }

                // Approval History (jika ada)
                if (d.status >= 16) {
                    let eafNo = d.eaf_ref_no || '-';
                    let approver = res.nama_approver_budget || '-';
                    let dateApp = res.approved_at_budget || '-';
                    let noteApprove = d.note_approve || '';
                    let htmlHist = `
                    <div class="alert alert-success border-success d-flex align-items-center shadow-sm">
                        <i class="bi bi-check-circle-fill fs-3 me-3 text-success"></i>
                        <div class="w-100">
                            <h6 class="fw-bold mb-1 text-success">Budgeting Disetujui & Terintegrasi EAF</h6>
                            <div class="row small mt-2">
                                <div class="col-md-4">
                                    <span class="text-muted d-block">Approved By:</span>
                                    <strong class="text-dark">${approver}</strong>
                                </div>
                                <div class="col-md-4">
                                    <span class="text-muted d-block">Date:</span>
                                    <strong class="text-dark">${dateApp}</strong>
                                </div>
                                <div class="col-md-4">
                                    <span class="text-muted d-block">No. EAF:</span>
                                    <strong class="text-primary">${eafNo}</strong>
                                </div>
                            </div>
                            ${noteApprove ? `<div class="mt-2 pt-2 border-top border-success-subtle"><span class="text-muted small fst-italic">Note: "${noteApprove}"</span></div>` : ''}
                        </div>
                    </div>`;
                    $("#shooting_approval_history").html(htmlHist).show();
                }
            },
            error: function(xhr) {
                alert("Gagal memuat detail shooting.");
            }
        });
    }

    $("#addShootingLink").click(function() {
        // 1. Hitung jumlah input link yang sudah ada
        let count = $("#shootingLinkContainer .link-item").length;

        // 2. Validasi Batas Maksimal (3)
        if (count >= 3) {
            $.alert({
                title: 'Batas Maksimum',
                content: 'Anda hanya dapat menambahkan maksimal 3 link riset.',
                type: 'orange',
                icon: 'fa fa-exclamation-triangle',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-orange'
                    }
                }
            });
            return; // Hentikan proses, jangan tambah input lagi
        }

        // 3. Jika belum mencapai batas, tambahkan input
        addShootingLinkInput("");
    });

    function addShootingLinkInput(value = "") {
        let html = `
        <div class="input-group mb-2 link-item">
            <span class="input-group-text"><i class="bi bi-link"></i></span>
            <input type="text" name="shooting_link[]" class="form-control form-control-sm shooting_link" value="${value}" placeholder="Masukkan Link Shooting">
            <button type="button" class="btn btn-danger btn-sm remove-shooting-link"><i class="bi bi-x"></i></button>
        </div>`;
        $("#shootingLinkContainer").append(html);
    }

    $(document).on('click', '.remove-shooting-link', function() {
        $(this).closest('.link-item').remove();
    });

    $("#btnSaveShooting").click(function() {
        let campaign_id = $("#shooting_campaign_id").val();

        // Validasi 
        if (!campaign_id) {
            showValidasi("Data campaign tidak ditemukan. Silakan muat ulang halaman.");
            return;
        }

        if ($('#keterangan').summernote('isEmpty')) {
            showValidasi("keterangan wajib diisi!");
            return;
        }

        if (filesShooting.length === 0) {
            showValidasi("Wajib upload minimal satu file!");
            return;
        }

        if ($("#lokasi").val().trim() === "") {
            showValidasi("Lokasi wajib diisi!");
            return;
        }


        let formData = new FormData($("#formShooting")[0]);
        formData.append("campaign_id", campaign_id);

        // Append Summernote Content
        formData.append("keterangan", $('#keterangan').summernote('code'));

        // Append Files Dropzone
        filesShooting.forEach(function(f) {
            formData.append("uploaded_files[]", f);
        });

        // AJAX Save
        $.ajax({
            url: baseUrl + "/save_shooting",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    $("#modalShooting").modal("hide");
                    showSuccess('Data shooting berhasil disimpan.');
                    loadKanbanData(5);
                } else {
                    $.alert({
                        title: 'Gagal',
                        content: res.message,
                        type: 'red'
                    });
                }
            },
            error: function() {
                $.alert({
                    title: 'Error',
                    content: 'Terjadi kesalahan server',
                    type: 'red'
                });
            }
        });
    });


    // --- VARIABLES ---
    function loadReviewShooting(campaign_id) {
        // 1. Reset UI
        $("#rv_shooting_campaign_id").val(campaign_id);
        // field control (bukan clear → biarkan jQuery)
        $("#rv_shooting_deadline_next").prop("disabled", false);
        $("#rv_shooting_deadline_info").addClass("d-none");

        // clear via helper
        clearElements([
            // val
            {
                id: "#rv_shooting_note_approve",
                action: "val"
            },
            {
                id: "#rv_shooting_deadline_next",
                action: "val"
            },

            // text "Loading..."
            {
                id: "#rv_shooting_campaign_name",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#rv_shooting_timeline",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#rv_shooting_deadline",
                action: "text",
                value: "Loading..."
            },

            // html "-"
            {
                id: "#rv_shooting_hist_description",
                action: "html"
            },
            {
                id: "#rv_shooting_riset_report",
                action: "html"
            },
            {
                id: "#rv_shooting_naskah_final",
                action: "html"
            },
            {
                id: "#rv_res_keterangan",
                action: "html"
            },

            // empty
            {
                id: "#rv_shooting_influencer_container",
                action: "empty"
            },
            {
                id: "#rv_shooting_camp_links",
                action: "empty"
            },
            {
                id: "#rv_shooting_camp_files",
                action: "empty"
            },
            {
                id: "#rv_shooting_riset_links",
                action: "empty"
            },
            {
                id: "#rv_shooting_riset_files",
                action: "empty"
            },
            {
                id: "#rv_shooting_kol_container",
                action: "empty"
            },
            {
                id: "#rv_shooting_approval_history_budget",
                action: "empty"
            },
            {
                id: "#rv_res_links",
                action: "empty"
            },
            {
                id: "#rv_res_files",
                action: "empty"
            },

            // text "-"
            {
                id: "#rv_res_lokasi",
                action: "text"
            },
            {
                id: "#rv_res_output",
                action: "text"
            }
        ]);


        // 2. Load Data Detail
        $.ajax({
            url: baseUrl + "/get_shooting_detail",
            type: "POST",
            data: {
                campaign_id: campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (!res.status) {
                    alert(res.message);
                    return;
                }
                const d = res.data;

                // --- HEADER INFO ---
                $("#rv_shooting_company_id").val(d.company_id);
                $("#rv_shooting_campaign_name").text(d.campaign_name);
                $("#rv_shooting_timeline").text((d.start_date || '-') + ' - ' + (d.end_date || '-'));
                $("#rv_shooting_deadline").text(d.deadline_shooting || '-');
                renderPriority(d.priority, "#rv_shooting_priority");
                renderPlacement(d.placement, "#rv_shooting_placement");
                renderPics(res.pics, "#rv_shooting_pics");
                $('#rv_shooting_note_approve').val(d.shooting_note_approve);

                // --- CAMPAIGN BRIEF ---
                renderInfluencerInfo(res.influencer_ref, "#rv_shooting_influencer_container");
                $("#rv_shooting_hist_description").html(d.description || '-');
                let campLinks = [d.reference_link, d.reference_link_2, d.reference_link_3].filter(Boolean);
                renderLinks(campLinks, "#rv_shooting_camp_links");
                let campFiles = [d.reference_file, d.reference_file_2, d.reference_file_3].filter(Boolean);
                let campPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/brief/";
                renderFiles(campFiles, "#rv_shooting_camp_files", campPath);
                $('#rv_shooting_hist_goals').text(d.goals || '-');
                $('#rv_shooting_hist_big_idea').text(d.big_idea || '-');

                // --- Riset Campaign ---
                $("#rv_shooting_riset_report").html(d.riset_report || '-');
                $("#rv_shooting_trend_analysis").html(d.trend_analysis || '-');
                $("#rv_shooting_riset_note").text(d.riset_note || '-');
                renderLinks(d.riset_link, "#rv_shooting_riset_links");
                let risetSpvPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/riset_spv/";
                renderFiles(d.riset_file, "#rv_shooting_riset_files", risetSpvPath);

                // --- Script ---
                $("#rv_shooting_script_note").text(d.script_note || '-');
                $("#rv_shooting_naskah_final").html(d.naskah_final || '-');


                $("#rv_res_lokasi").text(d.shooting_lokasi || '-');
                $("#rv_res_keterangan").html(d.shooting_keterangan || '-');
                renderLinks(d.shooting_link, "#rv_res_links");
                const shootingFiles = res.file_url_shooting ?
                    res.file_url_shooting.map(f => f.name) : [];

                let shootingPath = "<?= base_url('uploads/marcom/campaigns/') ?>" +
                    d.campaign_id + "/shooting/";

                renderFiles(shootingFiles, "#rv_res_files", shootingPath);

                if (res.output_nama && res.output_nama !== '-') {
                    let outs = res.output_nama.split(',');
                    let htmlOut = '';
                    outs.forEach(o => htmlOut += `<span class="badge bg-secondary">${o.trim()}</span> `);
                    $("#rv_res_output").html(htmlOut);
                } else {
                    $("#rv_res_output").text('-');
                }

                showDeadline(d.deadline_editing, d.company_id, 'rv_shooting_deadline_next');


                initSlimSelectReview('#rv_shooting_pic_next', d.company_id, 'modalReviewShooting');
            }
        });
    }

    // --- ACTION: APPROVE SHOOTING ---
    $("#btnApproveShooting").click(function() {
        let id = $("#rv_shooting_campaign_id").val();
        let note = $("#rv_shooting_note_approve").val();
        let pic = $("#rv_shooting_pic_next").val();
        let deadline = $("#rv_shooting_deadline_next").val();
        let company_id = $("#rv_shooting_company_id").val();

        // Validasi
        if (!pic || pic.length === 0) {
            showValidasi('PIC Editing wajib dipilih.');
            return;
        }
        if (!deadline || deadline.trim() === '') {
            showValidasi('Deadline Editing wajib diisi.');
            return;
        }

        if (!note || note.trim() === '') {
            showValidasi('Note Approve wajib diisi.');
            return;
        }

        $.confirm({
            title: 'Approve Shooting?',
            content: 'Status akan lanjut ke tahap <b>Editing</b>.',
            type: 'blue',
            buttons: {
                ya: {
                    text: 'Ya, Approve',
                    btnClass: 'btn-primary',
                    action: function() {
                        $.ajax({
                            url: baseUrl + "/approve_shooting",
                            type: "POST",
                            dataType: "json",
                            data: {
                                campaign_id: id,
                                note: note,
                                pic_next: pic, // Array user_id
                                deadline_next: deadline,
                                company_id: company_id
                            },
                            success: function(res) {
                                if (res.status) {
                                    sendNotifApprove(cid, 6);
                                    $("#modalReviewShooting").modal("hide");
                                    loadKanbanData(5); // Refresh tab Shooting (Done)
                                    showSuccess('Shooting approved dan lanjut ke Editing.');
                                } else {
                                    $.alert('Gagal: ' + res.message);
                                }
                            }
                        });
                    }
                },
                batal: function() {}
            }
        });
    });

    // --- ACTION: REJECT SHOOTING ---
    $("#btnRejectShooting").click(function() {
        let id = $("#rv_shooting_campaign_id").val();
        $.confirm({
            title: 'Revisi Shooting',
            content: 'Kembalikan status ke <b>In Progress</b> untuk direvisi?',
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'Ya, Kembalikan',
                    btnClass: 'btn-warning',
                    action: function() {
                        sendNotifReject(id, 5);
                        // ID, Tab 5, Status Baru 18, Status Lama 19
                        updateProgressBackend(id, 5, 18, 19);
                        $("#modalReviewShooting").modal("hide");
                        loadKanbanData(5);
                        $.alert({
                            title: 'Revisi!',
                            content: 'Task dikembalikan ke In Progress.',
                            type: 'orange',
                            icon: 'fa fa-exclamation-triangle',
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>

<!-- Editing -->
<script>
    let filesEditing = [];
    let dzEditing;

    dzEditing = new Dropzone("#dropzoneEditing", {
        url: "<?= base_url('marcom/upload_temp_files'); ?>",
        maxFiles: 3,
        acceptedFiles: ".pdf,.jpg,.jpeg,.png,.doc,.docx",
        addRemoveLinks: true,
        dictRemoveFile: "<i class='fa fa-trash'></i>",
        init: function() {
            this.on("success", function(file, response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status) {
                        file.serverFileName = res.filename;
                        filesEditing.push(res.filename);
                    }
                } catch (e) {}
            });
            this.on("removedfile", function(file) {
                let name = file.serverFileName || file.name;
                let idx = filesEditing.indexOf(name);
                if (idx !== -1) filesEditing.splice(idx, 1);
            });
        }
    });

    $("#addEditingLink").click(function() {
        let count = $("#editingLinkContainer .link-item").length;
        if (count >= 3) {
            $.alert({
                title: 'Info',
                content: 'Maksimal 3 link hasil editing.',
                type: 'orange'
            });
            return;
        }
        addEditingLinkInput("");
    });

    // Function Render Input Link
    function addEditingLinkInput(value = "") {
        let html = `
        <div class="input-group mb-2 link-item">
            <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
            <input type="text" name="editing_link[]" class="form-control form-control-sm" value="${value}" placeholder="Paste Link GDrive/Youtube...">
            <button type="button" class="btn btn-danger btn-sm remove-editing-link"><i class="bi bi-x"></i></button>
        </div>`;
        $("#editingLinkContainer").append(html);
    }

    // Handler Hapus Link
    $(document).on('click', '.remove-editing-link', function() {
        $(this).closest('.link-item').remove();
    });


    // 3. MAIN FUNCTION: LOAD DETAIL
    function loadEditingDetail(campaign_id) {
        // A. RESET UI
        $("#editing_campaign_id").val(campaign_id);
        $('#editing_keterangan').summernote('code', ''); // Reset Summernote
        dzEditing.removeAllFiles(true);
        filesEditing = []; // Reset array file

        clearElements([
            // empty
            {
                id: "#editingLinkContainer",
                action: "empty"
            },
            {
                id: "#ed_influencer_container",
                action: "empty"
            },
            {
                id: "#ed_camp_links",
                action: "empty"
            },
            {
                id: "#ed_camp_files",
                action: "empty"
            },
            {
                id: "#ed_kol_container",
                action: "empty"
            },
            {
                id: "#ed_hist_shooting_links",
                action: "empty"
            },
            {
                id: "#ed_hist_shooting_files",
                action: "empty"
            },

            // text "Loading..."
            {
                id: "#ed_campaign_name",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#ed_timeline",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#ed_deadline",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#ed_priority",
                action: "text",
                value: "Loading..."
            },

            // text "-"
            {
                id: "#ed_hist_goals",
                action: "text"
            },
            {
                id: "#ed_hist_big_idea",
                action: "text"
            },
            {
                id: "#ed_hist_description",
                action: "text"
            },
            {
                id: "#ed_total_budget",
                action: "text"
            },
            {
                id: "#ed_keperluan",
                action: "text"
            },
            {
                id: "#ed_hist_shooting_approve_note",
                action: "text"
            },
            {
                id: "#ed_hist_shooting_lokasi",
                action: "text"
            },
            {
                id: "#ed_hist_shooting_output",
                action: "text"
            },

            // html "-"
            {
                id: "#ed_riset_report",
                action: "html"
            },
            {
                id: "#ed_trend_analysis",
                action: "html"
            },
            {
                id: "#ed_riset_note",
                action: "html"
            },
            {
                id: "#ed_script_note",
                action: "html"
            },
            {
                id: "#ed_naskah_final",
                action: "html"
            },
            {
                id: "#ed_hist_shooting_keterangan",
                action: "html"
            }
        ]);


        $("#modalEditing").modal("show");

        // B. AJAX FETCH DATA
        $.ajax({
            url: baseUrl + "/get_editing_detail",
            type: "POST",
            data: {
                campaign_id: campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (!res.status) {
                    $.alert(res.message);
                    return;
                }
                const d = res.data;

                // --- 1. HEADER & BASIC INFO ---
                $("#ed_campaign_id").val(d.campaign_id);
                $("#ed_campaign_name").text(d.campaign_name);
                $("#ed_timeline").text((d.start_date || '-') + ' s/d ' + (d.end_date || '-'));
                $("#ed_deadline").text(d.deadline_editing || '-'); // Deadline Editing

                renderPriority(d.priority, "#ed_priority");
                renderPlacement(d.placement, "#ed_placement");
                renderPics(res.pics, "#ed_pics");

                // --- 2. POPULATE HISTORY (Accordions) ---

                // > Brief
                renderInfluencerInfo(res.influencer_ref, "#ed_influencer_container");
                $("#ed_hist_goals").text(d.goals || '-');
                $("#ed_hist_big_idea").text(d.big_idea || '-');
                $("#ed_hist_description").html(d.description || '-');
                renderLinks([d.reference_link, d.reference_link_2, d.reference_link_3], "#ed_camp_links");
                let briefPath = baseUrl.replace('/marcom', '') + "uploads/marcom/campaigns/" + d.campaign_id + "/brief/";
                renderFiles([d.reference_file, d.reference_file_2, d.reference_file_3], "#ed_camp_files", briefPath);

                // > Riset
                $("#ed_riset_report").html(d.riset_report || '-');
                $("#ed_trend_analysis").html(d.trend_analysis || '-');
                $("#ed_riset_note").text(d.riset_note || '-');

                // > Script
                $("#ed_script_note").text(d.script_note || '-');
                $("#ed_naskah_final").html(d.naskah_final || '-');

                // > KOL
                // if (res.kol_items.length > 0) {
                //     res.kol_items.forEach(k => {
                //         $("#ed_kol_container").append(`<div class="col-md-6"><div class="p-2 border rounded bg-light small fw-bold">${k.kol_nama}</div></div>`);
                //     });
                // } else {
                //     $("#ed_kol_container").html('<div class="col-12 text-muted small">Tidak ada data KOL</div>');
                // }

                // > Budget
                // $("#ed_total_budget").text(formatCurrencyDisplay(d.total_budget));
                // $("#ed_keperluan").text(d.nama_keperluan || '-');

                // > SHOOTING (Source Material)
                $("#ed_hist_shooting_approve_note").text(d.shooting_note_approve || '-');
                $("#ed_hist_shooting_lokasi").text(d.shooting_lokasi || '-');
                $("#ed_hist_shooting_keterangan").html(d.shooting_keterangan || '-');

                // Render Output Badges
                if (res.output_nama && res.output_nama !== '-') {
                    let outs = res.output_nama.split(',');
                    let htmlOut = '';
                    outs.forEach(o => htmlOut += `<span class="badge bg-secondary">${o.trim()}</span> `);
                    $("#ed_hist_shooting_output").html(htmlOut);
                } else {
                    $("#ed_hist_shooting_output").text('-');
                }

                // Render Shooting Links
                if (d.shooting_link) {
                    let sLinks = d.shooting_link.split(',');
                    renderLinks(sLinks, "#ed_hist_shooting_links");
                }

                // Render Shooting Files (Array Object from Backend)
                const shootingFiles = (res.file_url_shooting && res.file_url_shooting.length > 0) ?
                    res.file_url_shooting.map(f => f.name) : [];

                let shootingPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/shooting/";

                renderFiles(shootingFiles, "#ed_hist_shooting_files", shootingPath);

                // --- 3. POPULATE FORM EDITING (Jika Data Sudah Ada) ---
                if (d.editing_id) {
                    // Isi Summernote
                    $('#editing_keterangan').summernote('code', d.keterangan);

                    // Isi Link (Dynamic Inputs)
                    if (d.editing_link) {
                        let links = d.editing_link.split(',');
                        links.forEach(l => {
                            if (l.trim()) addEditingLinkInput(l);
                        });
                    } else {
                        addEditingLinkInput(""); // Default 1 kosong
                    }

                    // Isi Dropzone (Mock Files)
                    if (res.file_url_editing && res.file_url_editing.length > 0) {
                        res.file_url_editing.forEach(f => {
                            let mockFile = {
                                name: f.name,
                                size: 12345,
                                serverFileName: f.name,
                                status: Dropzone.ADDED
                            };
                            dzEditing.emit("addedfile", mockFile);

                            // Thumbnail check
                            if (f.name.match(/\.(jpg|jpeg|png|gif)$/i)) {
                                dzEditing.emit("thumbnail", mockFile, f.url);
                            } else {
                                dzEditing.emit("thumbnail", mockFile, null); // Default icon
                            }

                            dzEditing.emit("complete", mockFile);
                            filesEditing.push(f.name); // Push ke array global agar tidak hilang saat save
                            dzEditing.files.push(mockFile); // Push internal dropzone
                        });
                    }
                } else {
                    // Mode Create: Add 1 empty link input
                    addEditingLinkInput("");
                }
            },
            error: function() {
                $.alert("Gagal memuat data editing.");
            }
        });
    }

    // --- TOMBOL SAVE EDITING ---
    $("#btnSaveEditing").click(function() {
        // 1. Ambil ID
        let campaign_id = $("#editing_campaign_id").val();
        let keterangan = $('#editing_keterangan').val();

        if (keterangan.trim() === "" || keterangan === '<p><br></p>') {
            showValidasi("Keterangan wajib diisi.");
            return;
        }

        // 2. Validasi Sederhana
        // Cek apakah ada link atau file yang diupload (minimal satu bukti hasil)
        let hasLink = false;
        $("input[name='editing_link[]']").each(function() {
            if ($(this).val().trim() !== "") hasLink = true;
        });

        if (!hasLink) {
            showValidasi("Mohon isi setidaknya satu <b>Link</b>.");
            return;
        }

        // Cek array filesEditing (dari Dropzone global variable)
        let hasFile = filesEditing.length > 0;

        if (!hasFile) {
            showValidasi("Mohon isi setidaknya satu <b>File</b>.");
            return;
        }

        // 3. Siapkan FormData
        let formData = new FormData($("#formEditing")[0]);

        // Append Keterangan (Summernote)
        formData.append("keterangan", $('#editing_keterangan').summernote('code'));

        // Append File Dropzone (Array global filesEditing)
        filesEditing.forEach(function(f) {
            formData.append("uploaded_files[]", f);
        });

        // Button Loading State
        let btn = $(this);
        let originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        // 4. AJAX Posting
        $.ajax({
            url: baseUrl + "/save_editing",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                btn.prop('disabled', false).html(originalText);

                if (res.status) {
                    $("#modalEditing").modal("hide");
                    showSuccess('Data editing berhasil disimpan.');
                    loadKanbanData(6);
                } else {
                    $.alert({
                        title: 'Gagal',
                        content: res.message,
                        type: 'red'
                    });
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html(originalText);
                console.error(xhr);
                $.alert({
                    title: 'Error',
                    content: 'Terjadi kesalahan server saat menyimpan.',
                    type: 'red'
                });
            }
        });
    });


    // --- LOAD REVIEW EDITING ---
    function loadReviewEditing(campaign_id) {
        // 1. Reset UI
        $("#rv_editing_campaign_id").val(campaign_id);
        clearElements([
            // val
            {
                id: "#rv_editing_note_approve",
                action: "val"
            },
            {
                id: "#rv_editing_deadline_next",
                action: "val"
            },

            // text "Loading..."
            {
                id: "#rv_editing_campaign_name",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#rv_editing_timeline",
                action: "text",
                value: "Loading..."
            },
            {
                id: "#rv_editing_deadline",
                action: "text",
                value: "Loading..."
            },

            // text "-"
            {
                id: "#rv_ed_hist_shooting_lokasi",
                action: "text"
            },
            {
                id: "#rv_ed_hist_shooting_output",
                action: "text"
            },
            {
                id: "#rv_ed_hist_shooting_keterangan",
                action: "text"
            },

            // empty
            {
                id: "#rv_ed_hist_shooting_files",
                action: "empty"
            },
            {
                id: "#rv_res_editing_links",
                action: "empty"
            },
            {
                id: "#rv_res_editing_files",
                action: "empty"
            },

            // html "-"
            {
                id: "#rv_res_editing_keterangan",
                action: "html"
            }
        ]);


        // 2. Fetch Data
        $.ajax({
            url: baseUrl + "/get_editing_detail",
            type: "POST",
            data: {
                campaign_id: campaign_id
            },
            dataType: "json",
            success: function(res) {
                if (!res.status) {
                    alert(res.message);
                    return;
                }
                const d = res.data;

                // A. Header Info
                $("#rv_editing_company_id").val(d.company_id);
                $("#rv_editing_campaign_name").text(d.campaign_name);
                $("#rv_editing_timeline").text((d.start_date || '-') + ' - ' + (d.end_date || '-'));
                $("#rv_editing_deadline").text(d.deadline_editing || '-');
                renderPriority(d.priority, "#rv_editing_priority");
                renderPlacement(d.placement, "#rv_editing_placement");
                renderPics(res.pics, "#rv_editing_pics");

                // campaign brief
                renderInfluencerInfo(res.influencer_ref, "#rv_ed_influencer_container");
                $("#rv_ed_hist_goals").text(d.goals || '-');
                $("#rv_ed_hist_big_idea").text(d.big_idea || '-');
                $("#rv_ed_hist_description").html(d.description || '-');
                renderLinks([d.reference_link, d.reference_link_2, d.reference_link_3], "#rv_ed_camp_links");
                let briefPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/brief/";
                renderFiles([d.reference_file, d.reference_file_2, d.reference_file_3], "#rv_ed_camp_files", briefPath);

                // B. Riset
                $("#rv_ed_riset_report").html(d.riset_report || '-');
                $("#rv_ed_trend_analysis").html(d.trend_analysis || '-');
                $("#rv_ed_riset_note").text(d.riset_note || '-');
                renderLinks(d.riset_link, "#rv_ed_riset_links");
                let risetPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/riset_spv/";
                renderFiles(d.riset_file, "#rv_ed_riset_files", risetPath);

                // C. Script
                $("#rv_ed_script_note").text(d.script_note || '-');
                $("#rv_ed_naskah_final").html(d.naskah_final || '-');

                // B. History Shooting (Tampilkan sekilas)
                $("#rv_ed_hist_shooting_lokasi").text(d.shooting_lokasi || '-');
                if (res.output_nama && res.output_nama !== '-') {
                    let outs = res.output_nama.split(',');
                    let htmlOut = '';
                    outs.forEach(o => htmlOut += `<span class="badge bg-secondary">${o.trim()}</span> `);
                    $("#rv_ed_hist_shooting_output").html(htmlOut);
                } else {
                    $("#rv_ed_hist_shooting_output").text('-');
                }

                $("#rv_ed_hist_shooting_keterangan").html(d.shooting_keterangan || '-');

                if (res.file_url_shooting) {
                    const sFiles = res.file_url_shooting.map(f => f.name);
                    let sPath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/shooting/";
                    renderFiles(sFiles, "#rv_ed_hist_shooting_files", sPath);
                }

                if (d.shooting_link) {
                    renderLinks(d.shooting_link.split(','), "#rv_ed_hist_shooting_links");
                } else {
                    $("#rv_ed_hist_shooting_links").html('-');
                }

                // C. HASIL EDITING (Yang di-review)
                $("#rv_res_editing_keterangan").html(d.keterangan || '-');

                $('#rv_editing_note_approve').val(d.editing_keterangan || '');

                // Link
                if (d.editing_link) {
                    renderLinks(d.editing_link.split(','), "#rv_res_editing_links");
                }

                // Files/Thumbnail
                if (res.file_url_editing && res.file_url_editing.length > 0) {
                    const eFiles = res.file_url_editing.map(f => f.name);
                    let ePath = "<?= base_url('uploads/marcom/campaigns/') ?>" + d.campaign_id + "/editing/";
                    renderFiles(eFiles, "#rv_res_editing_files", ePath);
                }

                showDeadline(d.deadline, d.company_id, 'rv_editing_deadline_next');

                // Load PIC Next (Dropdown)
                initSlimSelectReview('#rv_editing_pic_next', d.company_id, 'modalReviewEditing');
            }
        });
    }

    // --- BUTTON APPROVE ---
    $("#btnApproveEditing").click(function() {
        let id = $("#rv_editing_campaign_id").val();
        let note = $("#rv_editing_note_approve").val();
        let pic = $("#rv_editing_pic_next").val();
        let deadline = $("#rv_editing_deadline_next").val();
        let company_id = $("#rv_editing_company_id").val();

        // Validasi
        if (!pic || pic.length === 0) {
            showValidasi('PIC Next wajib diisi.');
            return;
        }
        if (!deadline || deadline.trim() === '') {
            showValidasi('Deadline wajib diisi.');
            return;
        }

        if (!note || note.trim() === '') {
            showValidasi('Note Approve wajib diisi.');
            return;
        }

        $.confirm({
            title: 'Approve Editing?',
            content: 'Lanjut ke tahap selanjutnya.',
            type: 'blue',
            buttons: {
                ya: {
                    text: 'Approve',
                    btnClass: 'btn-primary',
                    action: function() {
                        $.post(baseUrl + "/approve_editing", {
                            campaign_id: id,
                            note: note,
                            pic_next: pic,
                            deadline_next: deadline,
                            company_id: company_id
                        }, function(res) {
                            if (res.status) {
                                $("#modalReviewEditing").modal("hide");
                                loadKanbanData(6);
                                showSuccess('Berhasil Approve!');
                            } else {
                                $.alert('Gagal: ' + res.message);
                            }
                        }, "json");
                    }
                },
                batal: function() {}
            }
        });
    });

    // --- BUTTON REJECT ---
    $("#btnRejectEditing").click(function() {
        let id = $("#rv_editing_campaign_id").val();
        $.confirm({
            title: 'Revisi Editing',
            content: 'Kembalikan status ke <b>In Progress</b> untuk direvisi?',
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'Ya, Kembalikan',
                    btnClass: 'btn-warning',
                    action: function() {
                        sendNotifReject(id, 6);
                        // Panggil API update_progress: ID, Tab 6, Status 22 (In Progress), Old 23
                        updateProgressBackend(id, 6, 22, 23);
                        $("#modalReviewEditing").modal("hide");
                        loadKanbanData(6);
                        $.alert({
                            title: 'Revisi!',
                            content: 'Task dikembalikan ke In Progress.',
                            type: 'orange',
                            icon: 'fa fa-exclamation-triangle',
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>