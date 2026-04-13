<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.js"></script>

<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script>

    $(function () { // Ini adalah shorthand untuk $(document).ready()

        $('.day-trigger').on('click', function () {
            var targetDay = $(this).data('day');
            $('.day-trigger').removeClass('active');
            $(this).addClass('active');
            $('.day-content').hide();
            $('#day-' + targetDay + '-content').show();
        });
        get_data_day()
        data_perlengkapan();
        data_bantuan();
    });

    $('#day-1-content').on('click', '.collapsible-trigger', function () {
        $(this).closest('.custom-collapsible').find('.collapsible-content').slideToggle(300);
        $(this).toggleClass('active');

    });
    $('#day-2-content').on('click', '.collapsible-trigger', function () {
        $(this).closest('.custom-collapsible').find('.collapsible-content').slideToggle(300);
        $(this).toggleClass('active');

    });
    $('#day-3-content').on('click', '.collapsible-trigger', function () {
        $(this).closest('.custom-collapsible').find('.collapsible-content').slideToggle(300);
        $(this).toggleClass('active');

    });

    $('#flexCheckDefault').on('change', function () {
        // Cek apakah checkbox sedang dicentang
        if ($(this).is(':checked')) {
            // Jika dicentang, HAPUS atribut 'disabled' dari tombol (tombol jadi aktif)
            $('#btn-setuju').prop('disabled', false);
        } else {
            // Jika tidak dicentang, TAMBAHKAN atribut 'disabled' (tombol jadi nonaktif)
            $('#btn-setuju').prop('disabled', true);
        }
    });

    // 2. Event listener saat tombol 'Setuju' di-klik
    $('#btn-setuju').on('click', function () {
        // Ambil nilai id dan link dari atribut data-* pada tombol
        const materiId = $(this).data('id');
        const materiLink = $(this).data('link');
        const tipe = 2;

        // Panggil fungsi add_history dengan data yang sudah diambil
        // add_history(materiId, materiLink, 2);

    });

    function get_data_day() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('timeline_onboarding/get_data_day'); ?>",
            // data: "data",
            dataType: "json",
            success: function (response) {
                if (response.day_1) {
                    renderDayContent(response.day_1, '#day-1-content');
                }

                // Panggil fungsi yang SAMA untuk day_2 jika datanya ada
                if (response.day_2) {
                    renderDayContent(response.day_2, '#day-2-content');
                }

                // Anda bisa tambahkan untuk day_3, day_4, dst. dengan mudah
                if (response.day_3) {
                    renderDayContent(response.day_3, '#day-3-content');
                }


            }
        });
    }
    function data_perlengkapan() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('timeline_onboarding/data_perlengkapan'); ?>",
            dataType: "json",
            success: function (response) {
                console.log(response);
                const container = $('#div_perlengkapan');
                container.empty();

                let allCardsHtml = '';

                response.forEach(item => {
                    let cardHtml = '';

                    // KONDISI 1: Jika status null, tampilkan form pengajuan (tetap seperti semula)
                    if (item.status == null) {
                        cardHtml = `
                        <div class="card border border-primary bg-light-primary rounded-3 shadow-none my-2">
                            <div class="card-body bg-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0">
                                        <i class=" bi bi-info-circle text-secondary me-2 fs-5"></i>
                                        ${item.label}
                                    </h6>
                                    <button class="btn btn-sm btn-link" onclick="form_pengajuan('${item.kode}')">Form <i
                                            class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    `;
                    }
                    // KONDISI 2: Jika status adalah 1, tampilkan kartu sukses (sesuai permintaan baru)
                    else if (item.status == 1) {
                        cardHtml = `
                        <div class="card border border-success bg-light-success rounded-3 shadow-none my-2">
                            <div class="card-body bg-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                        ${item.label}
                                    </h6>
                                    <p class="mb-0">${item.status_req}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    }
                    // KONDISI 3: Jika status memiliki nilai lain (misal: 0, 2, dll), tampilkan status progres
                    else {
                        cardHtml = `
                        <div class="card border border-secondary bg-light rounded-3 shadow-none my-2">
                            <div class="card-body bg-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-hourglass-split text-primary me-2 fs-5"></i>
                                        ${item.label}
                                    </h6>
                                    <p class="mb-0">${item.status_req}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    }

                    allCardsHtml += cardHtml;
                });

                container.html(allCardsHtml);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Gagal mengambil data perlengkapan:", textStatus, errorThrown);
            }
        });
    }

    function data_bantuan() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('timeline_onboarding/data_bantuan'); ?>",
            dataType: "json",
            success: function (response) {
                var container = $('#div_bantuan');
                let html = '';
                response.forEach(value => {
                    html = `<div class="contact-item">
                                        <img src="https://trusmiverse.com/hr/uploads/profile/${value.profile_picture}" alt="${value.nama}">
                                        <div class="name">${value.nama}</div>
                                        <div class="small text-muted">${value.designation_name}</div>
                                        <div class="small"><a href="https://wa.me/${value.contact_no}">Hubungi</a></div>
                                    </div>`;
                    container.append(html);
                });
            }
        });
    }
    const scrollAmount = 200;
    const container = $('#div_bantuan');
    $('#btn-scroll-right').on('click', function () {
        let currentScroll = container.scrollLeft();
        container.animate({
            scrollLeft: currentScroll + scrollAmount
        }, 300); // 300 adalah durasi animasi dalam milidetik
    });

    // Event listener untuk tombol scroll ke kiri
    $('#btn-scroll-left').on('click', function () {
        // Ambil posisi scroll saat ini, lalu kurangi dengan jarak yang ditentukan
        let currentScroll = container.scrollLeft();
        container.animate({
            scrollLeft: currentScroll - scrollAmount
        }, 300);
    });
    function add_history(id, link, tipe) {

        $.ajax({
            type: "POST",
            url: "<?= base_url('timeline_onboarding/add_history'); ?>",
            data: {
                id: id,
                link: link
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    if (id == 5) {
                        $('#modal_welcome').modal('hide');
                        return;
                    }
                    get_data_day();
                    window.open(link, '_blank');

                } else {
                    if (tipe == 2) {
                        window.open(link, '_blank');
                        return;
                    }
                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Done!',
                        theme: 'material',
                        type: 'blue',
                        content: 'Ceklis sudah di kerjakan!',
                        autoClose: 'ok|3000',
                    });
                }

            }
        });
    }

    function form_pengajuan(tipe) {
        $('.pengajuan-form').hide();
        let targetFormId = '';
        let modalTitle = 'Form Pengajuan';

        // 2. Tentukan form mana yang akan ditampilkan berdasarkan 'tipe'
        switch (tipe) {
            case 'id_card':
                targetFormId = '#form_id_card';
                modalTitle += ' ID Card';
                break;
            case 'kursi':
                targetFormId = '#form_kursi';
                modalTitle += ' Kursi';
                break;
            case 'seragam':
                targetFormId = '#form_seragam'; // Disesuaikan ID-nya
                modalTitle += ' Seragam';
                break;
            case 'akun_email':
                targetFormId = '#form_akun_email'; // Disesuaikan ID-nya
                modalTitle += ' Akun Email';
                break;
            case 'laptop':
                targetFormId = '#form_laptop'; // Disesuaikan ID-nya
                modalTitle += ' Laptop';
                break;
            default:
                console.error('Tipe form tidak dikenal:', tipe);
                return; // Hentikan fungsi jika tipe tidak valid
        }

        // 3. Tampilkan form yang dipilih
        $(targetFormId).show();
        $('#label_pengajuan').text(modalTitle);
        $('#submit_pengajuan_btn').attr('form', targetFormId.substring(1));
        $('#modal_pengajuan').modal('show');
    }

    $('#modal_pengajuan').on('submit', '.pengajuan-form', function (e) {
        e.preventDefault();
        const submittedForm = $(this);
        const formId = submittedForm.attr('id'); // Mendapatkan ID form, misal: 'form_id_card'
        const formData = submittedForm.serialize(); // Mengubah data form menjadi string query, misal: 'id_lokasi=jmp1'
        const submitButton = submittedForm.find('button[type="submit"]');
        const originalButtonHtml = submitButton.html();
        console.log(`Form ID: ${formId}`);
        console.log(`Data yang dikirim: ${formData}`);
        $.ajax({
            url: '<?= base_url('timeline_onboarding/insert_request'); ?>', // <-- GANTI DENGAN URL ENDPOINT ANDA
            type: 'POST',
            data: formData + '&form_id=' + formId, // Menambahkan form_id ke data yang dikirim
            beforeSend: function () {

                submitButton.prop('disabled', true);
                submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...');
            },
            success: function (response) {
                data_perlengkapan();
                // alert('Pengajuan berhasil dikirim!'); // Ganti dengan notifikasi yang lebih baik (misal: SweetAlert)
                $('#modal_pengajuan').modal('hide'); // Tutup modal
                $.confirm({
                    icon: 'fa fa-check',
                    title: 'Done!',
                    theme: 'material',
                    type: 'blue',
                    content: 'Berhasil di ajukan!',
                    autoClose: 'ok|3000',
                });
                submittedForm[0].reset(); // Reset isi form
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Terjadi kesalahan: ' + textStatus);
                console.error('AJAX Error:', errorThrown);
            },
            complete: function () {
                submitButton.prop('disabled', false);
                submitButton.html(originalButtonHtml);
            }
        });
    });



    // Fungsi ini bisa diletakkan di luar $.ajax
    function renderDayContent(data, containerSelector) {
        const mainContainer = $(containerSelector);
        mainContainer.html(''); // Kosongkan container

        if (!data || data.length === 0) {
            mainContainer.html('<p class="text-muted text-center">Tidak ada data untuk ditampilkan.</p>');
            return;
        }

        // 1. Kelompokkan data berdasarkan id_onboard
        const groupedData = data.reduce((acc, item) => {
            if (!acc[item.id_onboard]) {
                acc[item.id_onboard] = { nama: item.nama, items: [] };
            }
            acc[item.id_onboard].items.push(item);
            return acc;
        }, {});

        let allGroupsHtml = ''; // Tampung semua HTML grup di sini

        // 2. Loop setiap grup untuk membuat HTML
        for (const onboardId in groupedData) {
            const group = groupedData[onboardId];
            const totalModules = group.items.length;
            const completedModules = group.items.filter(item => item.done === '1').length;
            const progressPercentage = totalModules > 0 ? (completedModules / totalModules) * 100 : 0;

            let progressBadge = '';
            let progressBarClass = 'bg-secondary';

            if (progressPercentage === 100) {
                progressBadge = `<span class="badge bg-success fw-600">Selesai</span>`;
                progressBarClass = 'bg-success';
            } else if (progressPercentage > 0) {
                progressBadge = `<span class="badge bg-warning fw-600">Progres</span>`;
                progressBarClass = 'bg-warning';
            } else {
                progressBadge = `<span class="badge bg-secondary fw-600">Belum Dimulai</span>`;
            }

            // 3. Buat HTML untuk setiap item di dalam grup
            let itemsHtml = '';
            group.items.forEach(item => {
                const iconClass = item.done === '1' ? 'bi-check-circle-fill text-success' : 'bi-hourglass-split text-muted';

                // --- VALIDASI TOMBOL ---
                let actionButtonHtml = ''; // Siapkan variabel kosong untuk tombol
                // Hanya buat tombol jika item.link memiliki nilai (tidak null atau kosong)
                if (item.link) {
                    const buttonText = item.done === '1' ? 'Lihat Kembali' : 'Mulai';
                    const buttonClass = item.done === '1' ? 'btn-outline-secondary' : 'btn-primary';
                    // actionButtonHtml = `<a onclick="add_history(${item.id},'${item.link}','${item.tipe}')" class="btn btn-sm ${buttonClass}"><i class="bi bi-arrow-right"></i> ${buttonText}</a>`;
                    actionButtonHtml = `<a  href="${item.link}" target="_blank" class="btn btn-sm ${buttonClass}"><i class="bi bi-arrow-right"></i> ${buttonText}</a>`;
                }

                // --- VALIDASI BADGE STATUS ---
                let statusBadgeHtml = '';
                if (item.done === '1') {
                    statusBadgeHtml = `<span class="badge bg-light-green text-dark"><i class="bi bi-check-circle-fill"></i>Selesai pada : ${item.validated_at || ''}</span>`;
                } else {
                    statusBadgeHtml = `<span class="badge bg-light-yellow text-dark"><i class="bi bi-hourglass-split"></i>Menunggu Validasi</span>`;
                }

                itemsHtml += `
                <div class="card rounded-2 shadow-none border-light my-2">
                    <div class="card-body">
                        <h6 class="fw-600 title"><i class="bi ${iconClass} me-2 fs-5"></i> ${item.judul}</h6>
                        <p class="small text-muted mb-2">${item.deskripsi}</p>
                        ${actionButtonHtml}
                        ${statusBadgeHtml} 
                    </div>
                </div>
            `;
            });

            // 4. Gabungkan semua menjadi HTML grup
            allGroupsHtml += `
            <div class="p-3 rounded-3 mb-3 border border-success bg-light-success custom-collapsible">
                <div class="fw-600 collapsible-trigger" style="cursor: pointer;">
                    <div class="d-flex align-items-center">
                        <i class="bi ${icon_proses(progressPercentage)} me-2 fs-5"></i>
                        <span>${group.nama}</span>
                        <i class="bi bi-chevron-down ms-auto transition-transform"></i>
                    </div>
                    <div class="progress mt-2" style="height: 8px;">
                        <div class="progress-bar ${progressBarClass}" role="progressbar" style="width: ${progressPercentage}%;" aria-valuenow="${progressPercentage}"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        ${progressBadge}
                        <span class="text-muted small">${completedModules} dari ${totalModules} modul selesai</span>
                    </div>
                </div>
                <div class="collapsible-content" style="display: none;">
                    <hr class="my-2">
                    ${itemsHtml}
                </div>
            </div>
        `;
        }
        mainContainer.html(allGroupsHtml);
    }

    function icon_proses(value) {
        if (value == 100) {
            return `bi bi - check - circle - fill text - success`;
        } else {
            return `bi bi - hourglass - split text - secondary`;
        }
    }

</script>
<?php
$this->load->view('timeline_onboarding/js_chat.php');
?>