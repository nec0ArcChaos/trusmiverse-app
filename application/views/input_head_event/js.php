<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<!-- Tambahin ini di <head> atau sebelum </body> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
</link>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script>
    $(document).ready(function () {

        const baseurl2 = "<?= rtrim(base_url(), '/') ?>";

        var tableMasuk = $('#dt_mom').DataTable({
            searching: true,
            paging: true,
            info: true,
            lengthChange: false,
            responsive: true,
            ajax: {
                url: baseurl2 + "/input_head_event/get_mom",
                type: "POST",
                dataType: "json",
                dataSrc: "data" // WAJIB
            },
            columns: [
                {
                    data: "id_mom",
                    orderable: false,
                    render: function (data) {
                        return `
            <input type="radio"
                   name="mom_radio"
                   value="${data}">
        `;
                    }
                },
                {
                    data: "id_mom",
                    className: "fw-bold"
                },

                { data: "judul" },
                { data: "meeting" },
                { data: "department" },
                {
                    data: "pp_peserta",
                    render: function (data, type, row) {

                        if (!row.pp_peserta) {
                            return '-';
                        }

                        let avatar_pic = ``;
                        let avatar_pic_plus = ``;

                        let array_pic = row.pp_peserta.split(',');

                        // tampilkan max 2 avatar
                        for (let i = 0; i < array_pic.length; i++) {
                            if (i < 2) {
                                let foto = array_pic[i].trim();

                                avatar_pic += `
                    <div class="avatar avatar-30 coverimg rounded-circle"
                         style="background-image:url('http://trusmiverse.com/hr/uploads/profile/${foto}')">
                        <img src="http://trusmiverse.com/hr/uploads/profile/${foto}"
                             alt=""
                             style="display:none;">
                    </div>
                `;
                            }
                        }

                        if (array_pic.length > 2) {
                            avatar_pic_plus = `
                <div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                    <p class="small">${array_pic.length - 2}+</p>
                </div>
            `;
                        }

                        return `
            <div class="d-flex align-items-center"
                 data-bs-toggle="tooltip"
                 data-bs-placement="top"
                 title="${row.peserta}">
                ${avatar_pic}
                ${avatar_pic_plus}
            </div>
        `;
                    },
                    className: "d-none d-md-table-cell text-left"
                },
                {
                    data: "agenda",
                    render: d => d ? d.substring(0, 15) + '...' : '-'
                },
                {
                    'data': 'pembahasan',
                    'render': function (data, type, row) {
                        return `${data}`;
                    }
                },
                { data: "tempat", defaultContent: "-" },
                { data: "tgl", defaultContent: "-" },
                { data: "waktu", defaultContent: "-" },

                {
                    data: "peserta",
                    defaultContent: "-",
                    render: function (data) {
                        if (!data) return '-';
                        return `<ul class="mb-0 ps-3">` +
                            data.split(',').map(item => `<li>${item.trim()}</li>`).join('') +
                            `</ul>`;
                    }
                },

                {
                    data: "created_by",
                    className: "d-none d-md-table-cell text-left",
                    render: function (data, type, row) {
                        return `
                <div class="row">
                    <div class="col-auto align-self-center">
                        <figure class="avatar avatar-30 rounded-circle coverimg vm"
                                style="background-image:url('http://trusmiverse.com/hr/uploads/profile/${row.profile_picture}')">
                            <img src="http://trusmiverse.com/hr/uploads/profile/${row.profile_picture}"
                                 style="display:none;">
                        </figure>
                    </div>
                    <div class="col px-0 align-self-center">
                        <p class="mb-0 small">${row.username}</p>
                        <p class="small text-secondary mb-0">${row.created_at}</p>
                    </div>
                </div>
            `;
                    }
                }
            ]
        });

        // pilih radio

        
        $(document).on('change', 'input[name="mom_radio"]', function () {
            selectedMom = $(this).val();
        });

        let activeWeek = 1;
        let selectedMom = null;

        $('.week-check').on('change', function () {
            let week = $(this).closest('[data-week]').data('week');

            // checkbox jadi kayak radio
            $('.week-check').not(this).prop('checked', false);
            $(this).prop('checked', true);

            activeWeek = week;
        });


        $('.btn-primary').on('click', function () {

            if (!activeWeek) {
                alert('Pilih week terlebih dahulu');
                return;
            }

            if (!selectedMom) {
                alert('Pilih data MoM terlebih dahulu');
                return;
            }

            $.ajax({
                url: baseurl2 + '/input_head_event/save_mom_week',
                type: 'POST',
                data: {
                    week: activeWeek,
                    id_mom: selectedMom
                },
                success: function (res) {
                    alert('Data berhasil disimpan ke Week ' + activeWeek);

                    // optional reset
                    $('input[name="mom_radio"]').prop('checked', false);
                    selectedMom = null;
                }
            });
        });

        $('.btn-primary.shadow-sm:contains("Simpan Data")').on('click', function() {
        // Cek Week 2 (Lakukan hal yang sama untuk week lain)
        const selectedRadio2 = $('input[name="radio_week_2"]:checked');
        
        if (selectedRadio2.length > 0) {
            const noMom = selectedRadio2.data('nomor');
            const judul = selectedRadio2.data('judul');

            // 1. Jalankan AJAX Simpan ke DB beneran
            $.post("<?= base_url('input_head_event/save_selection') ?>", {
                week: 2,
                id_mom: noMom
            }, function(response) {
                // 2. Jika sukses, ubah tampilan UI secara instan
                $('#sum_no_2').text(noMom);
                $('#sum_judul_2').text(judul);
                
                $('#container_input_2').addClass('d-none');
                $('#container_summary_2').removeClass('d-none');
                $('#check_status_2').prop('checked', true);
                
                alert("Data Week 2 Berhasil Disimpan!");
            });
        }
        });
    });


</script>


<script>
    function switchContent(contentId, element) {
        // 1. Sembunyikan semua section konten
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {
            section.style.display = 'none';
        });

        // 2. Tampilkan konten yang dipilih
        document.getElementById(contentId).style.display = 'block';

        // 3. Hapus class 'active' dari semua nav-link di sidebar
        const navLinks = document.querySelectorAll('.event-sidebar .nav-link');
        navLinks.forEach(link => {
            link.classList.remove('active');
            // Reset icon warna (opsional)
            const icon = link.querySelector('i');
            if (icon) icon.className = 'bi bi-circle text-muted';
        });

        // 4. Tambahkan class 'active' ke menu yang diklik
        element.classList.add('active');
        const activeIcon = element.querySelector('i');
        if (activeIcon) activeIcon.className = 'bi bi-record-circle text-primary';
    }
</script>