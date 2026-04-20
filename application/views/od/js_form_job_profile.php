<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="https://cdn.tiny.cloud/1/pfscpy7tr16yqvxvbeoxg1so6c06xbvzin6mg5zo66x2w88g/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>

<script>
    let initDepartment, initRole, initCc, initApproval;
    let initDiverifikasi, initDisetujui, initMengetahui;

    $(document).ready(function () {
        // ===== Tab Detail =====
        initDepartment = new SlimSelect({
            select: "#department_id",
            settings: {
                placeholderText: 'Pilih Department',
                allowDeselect: true
            }
        });

        initRole = new SlimSelect({
            select: "#role_id",
            settings: {
                placeholderText: 'Pilih Role/Jabatan',
                allowDeselect: true
            }
        });

        initCc = new SlimSelect({
            select: "#cc",
            settings: {
                placeholderText: 'Pilih Employee',
                allowDeselect: true
            }
        });

        // ===== Tab Approval =====
        initApproval = new SlimSelect({
            select: "#approval",
            settings: {
                placeholderText: 'Pilih Approval',
                allowDeselect: true
            },
            events: {
                afterChange: (newVal) => {
                    if (newVal.length > 0 && newVal[0].data) {
                        $('#diverifikasi').val(newVal[0].data.nama_diverifikasi || '');
                        $('#disetujui').val(newVal[0].data.nama_disetujui || '');
                        $('#mengetahui').val(newVal[0].data.nama_mengetahui || '');
                    } else {
                        $('#diverifikasi, #disetujui, #mengetahui').val('');
                    }
                }
            }
        });

        // ===== Modal Add Approval — 3 SlimSelect PIC =====
        initDiverifikasi = new SlimSelect({
            select: '#diverifikasiOleh',
            dropdownParent: '#modal_add_approval',
            settings: { placeholderText: 'Pilih PIC Verifikasi', allowDeselect: true }
        });

        initDisetujui = new SlimSelect({
            select: '#disetujuiOleh',
            dropdownParent: '#modal_add_approval',
            settings: { placeholderText: 'Pilih PIC Persetujuan', allowDeselect: true }
        });

        initMengetahui = new SlimSelect({
            select: '#mengetahuiOleh',
            dropdownParent: '#modal_add_approval',
            settings: { placeholderText: 'Pilih PIC Mengetahui', allowDeselect: true }
        });

        // ===== TinyMCE — plain editor (tanpa background A4/kop surat) =====
        tinymce.init({
            selector: '#content-editor',
            plugins: 'table lists advlist link image preview code help autolink nonbreaking',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table | link preview',
            menubar: 'file edit view insert format table help',
            height: 500,
            nonbreaking_force_tab: true,
            branding: false
        });

        // ===== Initial loads =====
        get_all_pic();
        load_approvals();
        load_pic_for_approval_modal();

        // ===== Show/hide No. Dokumen berdasarkan Categori (smooth slide) =====
        $('#category').on('change', function () {
            if ($(this).val() === 'Revisi') {
                $('#wrap_no_dokumen').addClass('show');
            } else {
                $('#wrap_no_dokumen').removeClass('show');
                $('#no_dokumen').val('');
            }
        });

        // ===== Company → Department =====
        $('#company_id').on('change', function () {
            const companyId = $(this).val();
            loadDepartments(companyId);
        });
    });

    function loadDepartments(companyId) {
        initDepartment.setData([]);
        $.ajax({
            url: '<?= base_url("trusmi_memo/get_department"); ?>',
            type: 'POST',
            data: { company_id: companyId },
            dataType: 'json',
            success: function (response) {
                const departmentOptions = response.department.map(dept => ({
                    text: dept.department_name,
                    value: dept.department_id
                }));
                initDepartment.setData(departmentOptions);
            },
            error: function () {
                console.error('Gagal memuat department.');
            }
        });
    }

    function get_all_pic() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('trusmi_memo/get_all_pic'); ?>",
            dataType: "json",
            success: function (response) {
                const ccOptions = response.map(emp => ({
                    text: emp.nama,
                    value: emp.user_id
                }));
                initCc.setData(ccOptions);
            },
            error: function () {
                console.error('Gagal memuat data CC.');
            }
        });
    }

    function load_approvals() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('trusmi_memo/get_approval'); ?>",
            dataType: "json",
            success: function (response) {
                const list = (response || []).map(item => ({
                    text: item.nama,
                    value: item.id,
                    data: {
                        nama_diverifikasi: item.nama_diverifikasi,
                        nama_disetujui: item.nama_disetujui,
                        nama_mengetahui: item.nama_mengetahui
                    }
                }));
                list.unshift({
                    text: 'Pilih Approval',
                    placeholder: true,
                    disabled: true
                });
                initApproval.setData(list);
            },
            error: function () {
                console.error('Gagal memuat data Approval.');
            }
        });
    }

    function load_pic_for_approval_modal() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('trusmi_memo/get_all_pic'); ?>",
            dataType: "json",
            success: function (response) {
                const picOptions = (response || []).map(emp => ({
                    text: emp.nama,
                    value: emp.user_id
                }));
                initDiverifikasi.setData(picOptions);
                initDisetujui.setData(picOptions);
                initMengetahui.setData(picOptions);
            },
            error: function () {
                console.error('Gagal memuat data PIC untuk modal approval.');
            }
        });
    }

    function add_approval() {
        $('#form_add_approval')[0].reset();
        initDiverifikasi.setSelected([]);
        initDisetujui.setSelected([]);
        initMengetahui.setSelected([]);
        $('#modal_add_approval').modal('show');
    }

    $('#form_add_approval').on('submit', function (e) {
        e.preventDefault();
        const diverifikasiValues = initDiverifikasi.getSelected();
        const disetujuiValues = initDisetujui.getSelected();
        const mengetahuiValues = initMengetahui.getSelected();

        if (diverifikasiValues.length === 0 && disetujuiValues.length === 0 && mengetahuiValues.length === 0) {
            Swal.fire('Oops!', 'Harap pilih minimal satu orang PIC (Diverifikasi, Disetujui, atau Mengetahui).', 'error');
            return;
        }

        $.ajax({
            url: '<?= base_url("trusmi_memo/form_add_approval") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response) {
                    Swal.fire('Berhasil', 'Master Approval tersimpan', 'success');
                    $('#modal_add_approval').modal('hide');
                    load_approvals();
                }
            },
            error: function () {
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan Master Approval.', 'error');
            }
        });
    });

    function save_form() {
        const judul      = $('#judul').val();
        const jenis      = $('#jenis').val();
        const category   = $('#category').val();
        const no_dokumen = $('#no_dokumen').val();
        const priority   = $('#priority').val();
        const company_id = $('#company_id').val();
        const department = initDepartment.getSelected();
        const role       = initRole.getSelected();
        const cc         = initCc.getSelected();
        const tujuan     = $('#tujuan').val();
        const content    = tinymce.get('content-editor') ? tinymce.get('content-editor').getContent() : '';
        const approval   = $('#approval').val();
        const fileEl     = $('#file_lampiran')[0];
        const lampiran   = (fileEl && fileEl.files && fileEl.files[0]) ? fileEl.files[0].name : '(tidak ada)';

        // Validasi dasar (Tab Detail)
        if (!judul) { Swal.fire('Error', 'Judul wajib diisi', 'error'); return; }
        if (!jenis) { Swal.fire('Error', 'Jenis wajib dipilih', 'error'); return; }
        if (!category) { Swal.fire('Error', 'Categori wajib dipilih', 'error'); return; }
        if (category === 'Revisi' && !no_dokumen) {
            Swal.fire('Error', 'No. Dokumen wajib diisi untuk Revisi', 'error');
            return;
        }
        if (!priority) { Swal.fire('Error', 'Priority wajib dipilih', 'error'); return; }
        if (!company_id) { Swal.fire('Error', 'Company wajib dipilih', 'error'); return; }
        if (department.length === 0) { Swal.fire('Error', 'Department wajib dipilih', 'error'); return; }
        if (!tujuan) { Swal.fire('Error', 'Expected Outcome wajib diisi', 'error'); return; }

        // Prototype preview: tampilkan data yang akan disimpan (belum disimpan ke DB)
        const dataPreview = {
            judul: judul,
            jenis: jenis,
            category: category,
            no_dokumen: category === 'Revisi' ? no_dokumen : '(N/A)',
            priority: priority,
            company_id: company_id,
            department_id: department,
            role_id: role,
            cc: cc,
            tujuan: tujuan,
            content: content,
            approval_id: approval || '(belum dipilih)',
            lampiran: lampiran
        };

        console.log('Prototype data:', dataPreview);

        Swal.fire({
            icon: 'success',
            title: 'Prototype Preview',
            html: '<div style="text-align:left;font-size:12px;"><pre>' +
                JSON.stringify(dataPreview, null, 2) + '</pre></div>',
            width: 700,
            confirmButtonText: 'OK'
        });
    }
</script>
