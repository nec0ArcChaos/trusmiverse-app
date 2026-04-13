<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<?php
$tinymce_scripts = [
    'https://cdn.tiny.cloud/1/x3x77665fvpfoiky9l6ydvo1pr649y6t32uv3u6fpc9zfw0w/tinymce/7/tinymce.min.js', // Untuk Bulan ke-1, 4, 7, 10
    'https://cdn.tiny.cloud/1/8lz1zd123fi2vunsmunlz3es8womr4lxg459s43spc2k9ssf/tinymce/7/tinymce.min.js', // Untuk Bulan ke-2, 5, 8, 11
    'https://cdn.tiny.cloud/1/sg93wjsvh4uxi4sr7fn6qclcp0wibtqyfu948yhsthyuncju/tinymce/7/tinymce.min.js',  // Untuk Bulan ke-3, 6, 9, 12
    'https://cdn.tiny.cloud/1/pfscpy7tr16yqvxvbeoxg1so6c06xbvzin6mg5zo66x2w88g/tinymce/7/tinymce.min.js',  // Untuk Bulan ke-3, 6, 9, 12
];
$active_script_url = $tinymce_scripts[3];
echo '<script src="' . htmlspecialchars($active_script_url) . '" referrerpolicy="origin"></script>';
?>
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>


<script>
    $(document).ready(function () {
        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
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
        },);

        cb(start, end);
        dt_memo('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        // $('#btn_filter').on('click', function() {
        //     start = $('input[name="startdate"]').val();
        //     end = $('input[name="enddate"]').val();
        //     dt_memo(tart, end);
        // });
        $('.range').on('apply.daterangepicker', function (ev, picker) {
            // 'picker' adalah objek daterangepicker yang berisi tanggal baru
            var newStart = picker.startDate.format('YYYY-MM-DD');
            var newEnd = picker.endDate.format('YYYY-MM-DD');

            // 1. Panggil 'cb' untuk update tampilan input
            cb(picker.startDate, picker.endDate);

            // 2. Panggil fungsi filter data Anda
            dt_memo(newStart, newEnd, 0);
        });
        initCompany = new SlimSelect({
            select: "#company_id",
            dropdownParent: "#modal_add_memo"
        });

        initRole = new SlimSelect({
            select: "#role_id",
            dropdownParent: "#modal_add_memo",
            events: {
                // Setiap kali pilihan di #role_id berubah, panggil fungsi update
                afterChange: (newVal) => {
                    updateSelectStates();
                }
            }
        });

        initDepartment = new SlimSelect({
            select: "#department_id",
            dropdownParent: "#modal_add_memo"
        });
        initToperson = new SlimSelect({
            select: "#to_person",
            dropdownParent: "#modal_add_memo",
            events: {
                // Setiap kali pilihan di #to_person berubah, panggil fungsi update
                afterChange: (newVal) => {
                    updateSelectStates();
                }
            }
        });
        initApproval = new SlimSelect({
            select: "#approval",
            dropdownParent: "#modal_add_memo",
            settings: {
                placeholderText: 'Pilih Approval', // Teks placeholder Anda
                allowDeselect: true // Opsi tambahan agar placeholder muncul lagi setelah memilih
            },
            events: {
                // 'afterChange' akan berjalan setiap kali pilihan berubah
                afterChange: (newVal) => {
                    if (newVal.length > 0) {
                        const selectedInfo = newVal[0];
                        // 'selectedInfo.data' adalah objek data yang Anda definisikan di .map()
                        $('#dibuat').val(selectedInfo.data.nama_dibuat);
                        $('#diverifikasi').val(selectedInfo.data.nama_diverifikasi);
                        $('#disetujui').val(selectedInfo.data.nama_disetujui);
                        $('#mengetahui').val(selectedInfo.data.nama_mengetahui);
                    } else {
                        // Jika pilihan dikosongkan, kosongkan juga semua input field
                        $('#dibuat').val('');
                        $('#diverifikasi').val('');
                        $('#disetujui').val('');
                        $('#mengetahui').val('');
                    }
                }
            }
        });





        tinymce.init({
            selector: '#memo-editor',
            plugins: 'table lists advlist link image preview code help autolink nonbreaking',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table tablemergecells tablecellbackgroundcolor image insertTabButton | link preview',
            nonbreaking_force_tab: true,
            // contextmenu: 'link image table | inserttab',
            // advlist_number_styles: 'lower-alpha',
            table_background_color_map: [
                { title: 'Red Light', value: 'FFB3B3' },   // light red
                { title: 'Red', value: 'FF0000' },         // normal red
                { title: 'Red Dark', value: '800000' },    // dark red

                // BLUE
                { title: 'Blue Light', value: 'ADD8E6' },  // light blue
                { title: 'Blue', value: '0000FF' },        // normal blue
                { title: 'Blue Dark', value: '000080' },   // dark blue

                // GREEN
                { title: 'Green Light', value: '90EE90' }, // light green
                { title: 'Green', value: '008000' },       // normal green
                { title: 'Green Dark', value: '006400' },  // dark green

                // YELLOW
                { title: 'Yellow Light', value: 'FFFACD' },// light yellow (lemon chiffon)
                { title: 'Yellow', value: 'F1C40F' },      // normal yellow (golden)
                { title: 'Yellow Dark', value: 'B7950B' }
            ],
            menubar: 'file edit view insert format table help',
            height: 600,
            content_style: `
            /* Mengatur 'meja' di sekitar kertas */
            html {
                background: #e9e9e9;
            }

            /* Mengatur tampilan 'kertas' A4 DENGAN kop surat */
            body {
                /* --- Properti Latar Belakang (Urutan penting!) --- */
                background-color: white; /* 1. Atur warna dasar kertas menjadi putih */
                background-image: url(${header_memo}); /* 2. Timpa dengan gambar kop surat di atasnya */
                background-repeat: no-repeat;
                background-position: top center;
                background-size: 100% auto; /* Lebar gambar sesuai lebar kertas */
                
                /* --- Properti Dimensi & Posisi Kertas A4 --- */
                width: 21cm;
                min-height: 29.7cm; /* Kertas bisa lebih panjang jika konten banyak */
                margin: 1.5cm auto; /* Posisi kertas di tengah 'meja' */
                box-shadow: 0 0 10px rgba(0,0,0,0.15);
                
                /* --- Padding untuk memberi ruang pada header/footer KOP SURAT --- */
                /* SESUAIKAN NILAI INI AGAR PAS DENGAN GAMBAR ANDA! */
                padding-top: 150px;
                padding-bottom: 150px;
                padding-left: 2cm; /* Gunakan margin A4 standar untuk samping */
                padding-right: 2cm;

                /* --- Properti Font Dasar --- */
                font-family: 'Times New Roman', Times, serif;
                font-size: 12pt;
            }

            /* Style untuk page break (tidak berubah) */
            img.mce-pagebreak {
                border: 1px dashed #999;
                width: 100%;
                margin-top: 15px;
                margin-bottom: 15px;
            }

        }

    `,
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',

            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    });
                    reader.readAsDataURL(file);
                });

                input.click();
            },
            relative_urls: false,
            remove_script_host: false,
            images_upload_handler: function (blobInfo) {
                return new Promise((resolve, reject) => {
                    var formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    $.ajax({
                        url: '<?= base_url('trusmi_memo'); ?>/upload_image_content',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            try {
                                var json = typeof response === 'string' ? JSON.parse(response) : response;

                                if (json && typeof json.location == 'string') {
                                    // ✅ Ganti success() dengan resolve()
                                    resolve(json.location);
                                } else {
                                    // ❌ Ganti failure() dengan reject()
                                    reject('Invalid JSON response: ' + JSON.stringify(json));
                                }
                            } catch (e) {
                                // ❌ Ganti failure() dengan reject()
                                reject('Error parsing JSON response.');
                            }
                        },

                        // Jika AJAX gagal (misal: error 404, 500)
                        error: function (jqXHR, textStatus, errorThrown) {
                            // ❌ Ganti failure() dengan reject()
                            reject('Image upload failed: ' + textStatus + " (" + errorThrown + ")");
                        }
                    });
                });
            },
            setup: (editor) => {
                editor.ui.registry.addButton('insertTabButton', {
                    text: 'Insert Tab',
                    tooltip: 'Sisipkan karakter tab',
                    onAction: () => {
                        editor.execCommand('InsertText', false, '\t');
                    }
                });
            }
        });
        get_approval();
        get_all_pic();
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    document.addEventListener('focusin', (e) => {
        if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
            e.stopImmediatePropagation();
        }
    });

    var approval = [];
    var all_pic = [];
    var employees_for_admin = [];
    var slimTambahPic = null;




    function updateSelectStates() {
        const personHasValue = initToperson.getSelected().length > 0;
        const roleHasValue = initRole.getSelected().length > 0;
        if (personHasValue) {
            initRole.disable(); // Nonaktifkan #role_id
        } else {
            initRole.enable(); // Aktifkan #role_id
        }

        if (roleHasValue) {
            initToperson.disable(); // Nonaktifkan #to_person
        } else {
            initToperson.enable(); // Aktifkan #to_person
        }
    }

    const initDiverifikasi = new SlimSelect({
        select: '#diverifikasiOleh',
        dropdownParent: "#modal_add_approval",
        settings: {
            placeholderText: 'Pilih PIC Verifikasi',
            allowDeselect: true
        }
    });

    const initDisetujui = new SlimSelect({
        select: '#disetujuiOleh',
        dropdownParent: "#modal_add_approval",
        settings: {
            placeholderText: 'Pilih PIC Persetujuan',
            allowDeselect: true
        }
    });

    const initMengetahui = new SlimSelect({
        select: '#mengetahuiOleh',
        dropdownParent: "#modal_add_approval",
        settings: {
            placeholderText: 'Pilih PIC Mengetahui',
            allowDeselect: true
        }
    });
    const initCc = new SlimSelect({
        select: '#cc',
        dropdownParent: "#modal_add_approval",
        settings: {
            placeholderText: 'Pilih CC',
            allowDeselect: true
        }
    });

    var tabs = $('#memoTab .nav-link');
    var btnBack = $('#btn-back');
    var btnNext = $('#btn-next');
    var btnSave = $('#btn_save');

    var header_memo = "http://trusmiverse.com/kop_company/raja_sukses_propertindo.jpg";

    function updateButtons() {
        var activeTab = $('#memoTab .nav-link.active');
        var currentIndex = activeTab.parent().index(); // .parent() untuk mendapatkan <li>, lalu .index()
        var totalTabs = tabs.length;
        btnBack.toggleClass('d-none', currentIndex === 0);
        btnNext.toggleClass('d-none', currentIndex === totalTabs - 1);
        btnSave.toggleClass('d-none', currentIndex !== totalTabs - 1);
    }
    btnNext.on('click', function () {
        $('#memoTab .nav-link.active').parent().next().find('button').tab('show');
    });
    btnBack.on('click', function () {
        $('#memoTab .nav-link.active').parent().prev().find('button').tab('show');
    });
    tabs.on('shown.bs.tab', function () {
        updateButtons();
    });

    // Panggil fungsi sekali saat halaman siap untuk mengatur kondisi awal
    updateButtons();

    function loadDepartments(companyId, onCompleteCallback) {
        initDepartment.disable();
        $.ajax({
            url: '<?= base_url("trusmi_memo/get_department"); ?>',
            type: 'POST',
            data: { company_id: companyId },
            dataType: 'json',
            success: function (response) {
                const departmentOptions = response.department.map(dept => ({
                    text: dept.department_name,
                    value: dept.department_id,
                    data: {
                        header: dept.header_memo
                    }
                }));

                initDepartment.setData(departmentOptions);
                initDepartment.enable();
                if (typeof onCompleteCallback === 'function') {
                    onCompleteCallback();
                }
            },
            error: function () {
                initDepartment.enable();
                console.error('Failed to load departments.');
            }
        });
    }
    function loadToperson(department_id, onCompleteCallback) {

        initToperson.disable();
        let departmentIdsToSend = [];

        // Cek apakah input sudah berupa array
        if (Array.isArray(department_id)) {
            departmentIdsToSend = department_id;
        }
        // Jika bukan array tapi ada isinya (string atau angka)
        else if (department_id) {
            // Ubah menjadi string (jaga-jaga jika itu angka), lalu split berdasarkan koma.
            // Ini akan mengubah "21" menjadi ['21'] dan "21,23" menjadi ['21', '23'].
            departmentIdsToSend = String(department_id).split(',');
        }
        // --- AKHIR PERBAIKAN ---

        // Jika setelah diproses array tetap kosong, hentikan fungsi.
        if (departmentIdsToSend.length === 0) {
            // initToperson.setData([]); // Kosongkan pilihan
            initToperson.enable();
            return;
        }

        $.ajax({
            url: '<?= base_url("trusmi_memo/get_employee"); ?>',
            type: 'POST',
            data: { department_id: departmentIdsToSend },
            dataType: 'json',
            success: function (response) {
                const topersonoption = response.map(emp => ({
                    text: emp.nama,
                    value: emp.user_id
                }));

                initToperson.setData(topersonoption);
                initToperson.enable();
                if (typeof onCompleteCallback === 'function') {
                    onCompleteCallback();
                }
            },
            error: function () {
                initToperson.enable();
                console.error('Failed to load departments.');
            }
        });
    }


    function add_memo() {
        $("#modal_add_memo").modal("show");
        $('#label_form_memo').text('Form Memo')
        $('.row_revisi').hide();
        $('.ss-main').css('height', 'auto');
        append_approval();
        resetMemoForm();
        starter_template('Memo Internal');



    }
    function get_all_pic() {
        if (all_pic.length === 0) {

            $.ajax({
                type: "POST",
                url: "<?= base_url('trusmi_memo/get_all_pic'); ?>",
                dataType: "json",
                success: function (response) {
                    // Setelah berhasil, isi variabel 'all_pic' dengan data dari response
                    all_pic = response;
                    populateSlimSelects(all_pic);
                },
                error: function (xhr, status, error) {
                }
            });
        } else {
        }
    }
    $('#jenis').change(function (e) {
        e.preventDefault();
        var tipe = $('#jenis :selected').text();
        starter_template(tipe)
    });
    function starter_template(tipe) {
        const templateContent = `
        <div class="starter-template mceNonEditable" contenteditable="false">
            <h5 style="text-align: center; margin-bottom: 0; text-decoration:underline; font-weight:bold">${tipe ?? 'Memo Internal'}</h5>
            
            <small style="text-align: center; display: block;">
                Nomer Memo (Otomatis)
            </small>
            <table style="width: 100%; border: none; font-size: 12pt; font-family: 'Times New Roman', Times, serif;">
                <tbody>
                    
                    <tr>
                        <td><strong>Perihal</strong></td>
                        <td>:</td>
                        <td>[di ambil dari input judul]</td>
                    </tr>
                    <tr>
                        <td><strong>Tgl. Rilis</strong></td>
                        <td>:</td>
                        <td>[-]</td>
                    </tr>
                </tbody>
            </table>
        </div>
        `;

        const editor = tinymce.get('memo-editor');
        editor.setContent(templateContent);
    }
    function append_approval() {
        const formattedApproval = approval.map(item => {
            return {
                text: item.nama,        // Teks yang akan ditampilkan
                value: item.id,         // Nilai dari option
                data: {
                    dibuat: item.dibuat,
                    deverifikasi: item.deverifikasi,
                    disetujui: item.disetujui,
                    mengetahui: item.mengetahui,
                    nama_dibuat: item.nama_dibuat,
                    nama_diverifikasi: item.nama_diverifikasi,
                    nama_disetujui: item.nama_disetujui,
                    nama_mengetahui: item.nama_mengetahui,
                }
            };
        });
        formattedApproval.unshift({
            text: 'Pilih Approval', // Teks yang akan ditampilkan
            placeholder: true,      // Properti khusus Slim Select untuk styling placeholder
            disabled: true,         // Membuat opsi ini tidak dapat dipilih
        });
        initApproval.setData(formattedApproval);
    }

    function submit_memo(action) {
        var formData = new FormData();
        const id_memo = $('#id_memo').val();
        const judul = $('#judul').val().trim();
        const priority = $('#priority').val();
        const category = $('#category').val();
        const approval = $('#approval').val();
        const tujuan = $('#tujuan').val();
        const jenis = $('#jenis').val();
        const id_revisi = $('#id_revisi').val();

        formData.append('id_memo', id_memo);
        formData.append('judul', judul);
        formData.append('priority', priority);
        formData.append('category', category);
        formData.append('approval', approval);
        formData.append('tujuan', tujuan);
        formData.append('jenis', jenis);
        formData.append('id_revisi', id_revisi);
        formData.append('company_id', initCompany.getSelected());


        const selectedDepartments = initDepartment.getSelected();
        if (Array.isArray(selectedDepartments)) {
            selectedDepartments.forEach(deptId => {
                formData.append('department_id[]', deptId);
            });
        }
        const select_person = initToperson.getSelected();
        if (Array.isArray(select_person)) {
            select_person.forEach(user_id => {
                formData.append('to_person[]', user_id);
            });
        }


        const selectedRoles = initRole.getSelected();
        if (Array.isArray(selectedRoles)) {
            selectedRoles.forEach(roleId => {
                formData.append('role_id[]', roleId);
            });
        }
        const selectedCc = initCc.getSelected();
        if (Array.isArray(selectedCc)) {
            selectedCc.forEach(value => {
                formData.append('cc[]', value);
            });
        }

        const memoContent = tinymce.get('memo-editor').getContent();
        formData.append('content', memoContent);
        const fileInput = document.getElementById('file_memo');
        // Cek jika ada file yang dipilih
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            // Tambahkan file ke formData. 'lampiran_memo' adalah nama yang akan diterima di PHP
            formData.append('lampiran_memo', file);
        }

        if (action == 'draf') {
            if (judul === '') {
                swal('Opps!', 'Setidaknya Judul tidak kosong untuk draf memo', 'error');
                return; // Hentikan eksekusi fungsi
            }
        }

        if (action === 'save') {
            if (judul === '') {
                swal('Opps!', 'Judul memo tidak boleh kosong.', 'error');
                return; // Hentikan eksekusi fungsi
            }
            if (judul.length < 3) {
                swal('Opps!', 'Judul memo minimal harus 3 karakter.', 'error');
                return; // Hentikan eksekusi fungsi
            }
            if (!priority) { // Cek jika null atau string kosong
                swal('Opps!', 'Prioritas harus dipilih.', 'error');
                return;
            }
            if (!category) {
                swal('Opps!', 'Kategori harus dipilih.', 'error');
                return;
            }
            if (!approval) {
                swal('Opps!', 'Approval harus dipilih.', 'error');
                return;
            }
            if (initCompany.getSelected() == "") {
                swal('Opps!', 'Perusahaan harus dipilih.', 'error');
                return;
            }
            if (!Array.isArray(selectedDepartments) || selectedDepartments.length === 0) {
                swal('Opps!', 'Departemen harus dipilih.', 'error');
                return;
            }
            // if (!Array.isArray(selectedRoles) || selectedRoles.length === 0) {
            //     swal('Opps!', 'Role Belum di pilih', 'error');
            //     return;
            // }
            if (!memoContent.trim()) {
                swal('Opps!', 'Konten memo tidak boleh kosong.', 'error');
                return;
            }
        }

        const targetUrl = `<?= base_url('trusmi_memo/'); ?>${action}`;

        $.ajax({
            type: "POST",
            url: targetUrl, // URL dinamis
            data: formData,
            dataType: "json",
            processData: false, // Wajib untuk FormData
            contentType: false, // Wajib untuk FormData
            success: function (response) {
                // Swal.close(); // Tutup loading
                if (response.status === true) {
                    swal('Info!', 'Data Saved!', 'success');
                } else {
                    swal('Info!', response.message || 'An unknown error occurred. Please check the console.', 'error');
                }
                $('#modal_add_memo').modal('hide');
                $('#dt_memo').DataTable().ajax.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Swal.close(); // Tutup loading
                swal('Info!', 'Could not connect to the server. Please try again later.', 'error');
            }
        });
    }


    function isStrictUrl(string) {
        const pattern = /^https?:\/\/[^\s/$.?#].[^\s]*$/i;
        return pattern.test(string);
    }

    function dt_memo(start, end) {
        load_data('#dt_memo', start, end, 0);
    }

    function list_approval(tipe) {
        tipe_data = 3;
        if (tipe == 1) {
            tipe_data = 3;
            $('#label_modal').text('List Approval Memo');

        } else {
            tipe_data = 4;
            $('#label_modal').text('List Approval Memo Sekdir');
        }
        $('#modal_data_memo').modal('show');
        start = $('input[name="start"]').val();
        end = $('input[name="end"]').val();
        load_data('#dt_memo_modal', start, end, tipe_data);
    }

    function list_draf() {
        $('#label_modal').text('List Draf Memo');
        $('#modal_data_memo').modal('show');
        start = $('input[name="start"]').val();
        end = $('input[name="end"]').val();
        load_data('#dt_memo_modal', start, end, 1);
    }
    function my_memo() {
        $('#label_modal').text('List My Memo');
        $('#modal_data_memo').modal('show');
        start = $('input[name="start"]').val();
        end = $('input[name="end"]').val();
        load_data('#dt_memo_modal', start, end, 5);
    }

    function load_data(table, start, end, tipe) {
        $(table).DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>trusmi_memo/data_memo",
                "data": {
                    start: start,
                    end: end,
                    tipe: tipe
                },
                'dataSrc': ''
            },
            "columns": [
                {
                    "data": "id_memo",
                    "render": function (data, type, row) {
                        btn_onclick = '';
                        if (tipe == 0) {
                            // Pastikan kode JavaScript ini berada di dalam file .php agar base_url() bisa dieksekusi
                            return `<a href="<?= base_url('trusmi_memo/read'); ?>/${row.url}" target="_blank" class="badge text-bg-success py-2">${data}</a>`;
                        } else {
                            // Untuk tipe lainnya, gunakan logika yang sudah ada untuk membuat tag 'span'
                            let btn_onclick = '';

                            if (tipe == 1) { //draf
                                btn_onclick = `onclick="get_memo('${data}',1)"`;
                            }
                            if (tipe == 3) { //waiting approval
                                const safe_judul = encodeURIComponent(row.judul);
                                const safe_category = encodeURIComponent(row.category);

                                btn_onclick = `onclick="approve_memo('${row.id_approval}','${data}','${safe_judul}','${safe_category}','${row.ttd_digital}')"`;
                            }
                            if (tipe == 4) { //waiting approval sekdir
                                const safe_judul = encodeURIComponent(row.judul);
                                const safe_category = encodeURIComponent(row.category);
                                btn_onclick = `onclick="approve_memo_sekdir('${row.id_approval}','${data}','${safe_judul}','${safe_category}','${row.ttd_digital}')"`;
                            }

                            return `<span class="badge text-bg-success py-2" style="cursor:pointer;" ${btn_onclick}>${data}</span>`;
                        }
                    }
                },
                {
                    "data": "nomer" // Pastikan backend mengirim 'company_name'
                },
                {
                    "data": "jenis"
                },
                {
                    "data": "company_name" // Pastikan backend mengirim 'company_name'
                },
                {
                    "data": "department_name",
                    "className": "wide-coloumn",
                },
                {
                    "data": "judul"
                },
                {
                    "data": "category",
                    "render": function (data, type, row) {
                        if (!data) return '';
                        return `<span class="badge bg-light-blue text-blue"><i class="${row.icon_category}"></i> ${data}</span>`;
                    }
                },
                {
                    "data": "priority",
                    "render": function (data, type, row) {
                        if (!data) return '';
                        return `<span class="badge ${row.color_priority}">${data}</span>`;
                    }
                },
                {
                    "data": "status",
                    "render": function (data, type, row) {
                        let html_output = `<span class="badge ${row.color_status}">${data}</span>`;
                        if (row.is_admin == 1 && row.revisi_by_name != null) {
                            const revisi_list = row.revisi_by_name.split(',');
                            revisi_list.forEach((revisi_entry, index) => {
                                const parts = revisi_entry.split('|');
                                const name = parts[0] ? parts[0].trim() : 'Revisor tidak dikenal';
                                const note = parts[1] ? parts[1].trim() : '';
                                html_output += `<br>`;
                                html_output += `<span class="badge bg-danger" onclick="get_memo('${row.id_memo}',2)" style='cursor:pointer'>Revisi by ${name}</span>`;
                                if (note) {
                                    html_output += `<br><small class="text-muted">Note: ${note}</small>`;
                                }
                            });
                        }
                        return html_output;
                    }
                },
                {
                    "data": "role_name" // Pastikan backend mengirim 'role_name'
                },
                {
                    "data": "content",
                    'render': function (data, type, row) {
                        return `<a class="badge bg-primary p-1 mb-1" href="<?= base_url('trusmi_memo/read'); ?>/${row.url}" target="_blank"><i class="bi bi-eye"></i> Lihat</a> <button class="badge bg-primary p-1 mb-1 copy-link-btn" data-url="<?= base_url('trusmi_memo/read'); ?>/${row.url}"><i class="bi bi-clipboard"></i> Copy Link</button>`;
                    }
                },
                {
                    "data": "personal",
                    // "className": "wide-coloumn",
                },
                {
                    "data": "tujuan",
                    "className": "wide-coloumn",
                },
                {
                    "data": "lampiran", // Pastikan backend mengirim 'files_memo'
                    "render": function (data, type, row) {
                        if (data) {
                            // Anda bisa menggunakan logika file dari kode lama Anda di sini
                            return `<a href="<?= base_url("uploads/files_memo/") ?>${data}" target="_blank" title="Lihat Lampiran"><i class="bi bi-paperclip"></i> Lihat</a>`;
                        }
                        return 'Tidak ada';
                    }
                },
                {
                    "data": "approval_status", // Pastikan backend mengirim 'approval_status'
                    "className": "wide-coloumn",
                    "render": function (data, type, row) {
                        let content = '';
                        // if (row.dibuat) {
                        //     content += `Dibuat Oleh: <br><strong>${row.dibuat}</strong><br>`;
                        // }
                        if (row.diverifikasi) {
                            content += `Diverifikasi Oleh: <br><strong>${row.diverifikasi}</strong><br>`;
                        }
                        if (row.disetujui) {
                            content += `Disetujui Oleh: <br><strong>${row.disetujui}</strong><br>`;
                        }
                        if (row.mengetahui) { // Typo corrected from 'mengetehui' to 'mengetahui'
                            content += `Mengetahui: <br><strong>${row.mengetahui}</strong>`;
                        }

                        // Remove trailing <br> if it exists
                        if (content.endsWith('<br>')) {
                            content = content.slice(0, -4);
                        }

                        return content || '-'; // Return a dash if all are null
                    }
                },
                {
                    "data": "list_cc" // Pastikan backend mengirim 'created_by_name'
                },
                {
                    "data": "created_by_name" // Pastikan backend mengirim 'created_by_name'
                },

                {
                    "data": "created_at"
                }
            ],
        });
    }





    function show_pic() {
        $('#modal_pic_admin').modal('show');
        if ($.fn.DataTable.isDataTable('#dt_admin_pic')) {
            $('#dt_admin_pic').DataTable().destroy();
        }

        function buildPicTable() {
            var dt = $('#dt_admin_pic').DataTable({
                processing: true,
                scrollX: true,
                autoWidth: false,
                dom: 'lfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data PIC Admin Memo',
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                }],
                ajax: {
                    url: '<?= base_url('trusmi_memo/get_admin_pic') ?>',
                    type: 'POST',
                    dataSrc: ''
                },
                columns: [
                    { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },
                    { data: 'admin' },
                    { data: 'nama', defaultContent: '-' },
                    { data: 'designation_name', defaultContent: '-', width: '300px', className: 'wide-coloumn' },
                    { data: 'department_name', defaultContent: '-', width: '300px', className: 'wide-coloumn' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<button type="button" class="badge bg-primary p-1 mb-1 btn-ganti-pic"
                                data-id="${row.id}" data-admin="${row.admin}">Ganti PIC</button>
                                <button type="button" class="badge bg-danger p-1 mb-1 btn-hapus-pic"
                                data-id="${row.id}">Hapus</button>`;
                        }
                    },
                    { data: 'updated_at', defaultContent: '-' },
                    { data: 'updated_by_name', defaultContent: '-' }

                ]
            });

            $('#btn_export_pic_excel').off('click.picexcel').on('click.picexcel', function() {
                dt.button(0).trigger();
            });

            $('#dt_admin_pic').off('.picadmin')
                .on('click.picadmin', '.btn-ganti-pic', function() {
                    var id      = $(this).data('id');
                    var current = $(this).data('admin');
                    var td      = $(this).closest('td');
                    var uid     = 'sel_pic_' + id;

                    td.html(`
                        <div class="d-flex gap-1 align-items-center flex-wrap">
                            <select id="${uid}" style="min-width:260px;"></select>
                            <button type="button" class="btn btn-sm btn-success btn-simpan-pic" data-id="${id}" data-uid="${uid}">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-batal-pic" data-uid="${uid}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    `);

                    new SlimSelect({
                        select: '#' + uid,
                        data: employees_for_admin.map(function(emp) {
                            return { text: emp.nama + ' (' + emp.username + ')', value: emp.username, selected: emp.username === current };
                        }),
                        settings: {
                            searchText: 'Tidak ditemukan',
                            searchPlaceholder: 'Cari nama...'
                        }
                    });
                })
                .on('click.picadmin', '.btn-batal-pic', function() {
                    var uid = $(this).data('uid');
                    var ss = SlimSelect.instances ? SlimSelect.instances['#' + uid] : null;
                    if (ss) { try { ss.destroy(); } catch(e) {} }
                    dt.ajax.reload();
                })
                .on('click.picadmin', '.btn-simpan-pic', function() {
                    var id          = $(this).data('id');
                    var uid         = $(this).data('uid');
                    var newUsername = $('#' + uid).val();
                     swal({
            title: "Confirm!",
            text: "Anda Yakin dengan perubahan ini?",
            icon: "info",
            buttons: true,
            dangerMode: false,
        })
            .then((simpan) => {
                if (simpan) {
                    $.ajax({
                        url:      '<?= base_url('trusmi_memo/update_admin_pic') ?>',
                            type:     'POST',
                            data:     { id: id, username: newUsername },
                            dataType: 'json',
                            success: function(res) {
                                if (res.status) {
                                    swal('Success!', 'PIC berhasil diperbarui!', 'success');
                                    dt.ajax.reload();
                                } else {
                                    swal('Error!', res.message || 'Gagal memperbarui PIC.', 'error');
                                }
                            },
                            error: function() {
                                swal('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                            }
                    });
                }
            });
    })
    .on('click.picadmin', '.btn-hapus-pic', function() {
        var id = $(this).data('id');
        swal({
            title: "Hapus PIC?",
            text: "Data PIC ini akan dihapus permanen!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then(function(hapus) {
            if (hapus) {
                $.ajax({
                    url: '<?= base_url('trusmi_memo/delete_admin_pic') ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            swal('Berhasil!', 'PIC berhasil dihapus.', 'success');
                            dt.ajax.reload();
                        } else {
                            swal('Error!', res.message || 'Gagal menghapus PIC.', 'error');
                        }
                    },
                    error: function() {
                        swal('Error!', 'Terjadi kesalahan server.', 'error');
                    }
                });
            }
        });
    });
        }

        function initTambahPicSlim() {
            if (slimTambahPic) { slimTambahPic.destroy(); slimTambahPic = null; }
            var opts = [{ text: '-- Pilih Karyawan --', value: '', placeholder: true }];
            opts = opts.concat(employees_for_admin.map(function(emp) {
                return { text: emp.nama + ' (' + emp.username + ')', value: emp.username };
            }));
            slimTambahPic = new SlimSelect({
                select: '#sel_new_pic',
                data: opts,
                settings: {
                    searchText: 'Tidak ditemukan',
                    searchPlaceholder: 'Cari nama karyawan...',
                    placeholderText: '-- Pilih Karyawan --',
                    allowDeselect: true
                }
            });
        }

        // Reset form state setiap buka modal
        $('#form_tambah_pic').addClass('d-none');
        if (slimTambahPic) { slimTambahPic.destroy(); slimTambahPic = null; }

        $('#btn_show_tambah_pic').off('click.tambahpic').on('click.tambahpic', function() {
            $('#form_tambah_pic').toggleClass('d-none');
            if (!$('#form_tambah_pic').hasClass('d-none')) {
                initTambahPicSlim();
            }
        });
        $('#btn_batal_tambah_pic').off('click.tambahpic').on('click.tambahpic', function() {
            $('#form_tambah_pic').addClass('d-none');
            if (slimTambahPic) { slimTambahPic.destroy(); slimTambahPic = null; }
        });
        $('#btn_simpan_tambah_pic').off('click.tambahpic').on('click.tambahpic', function() {
            var username = $('#sel_new_pic').val();
            if (!username) {
                swal('Opps!', 'Pilih karyawan terlebih dahulu.', 'warning');
                return;
            }
            $.ajax({
                url:      '<?= base_url('trusmi_memo/insert_admin_pic') ?>',
                type:     'POST',
                data:     { username: username },
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        swal('Success!', 'PIC berhasil ditambahkan!', 'success');
                        $('#form_tambah_pic').addClass('d-none');
                        if (slimTambahPic) { slimTambahPic.destroy(); slimTambahPic = null; }
                        if ($.fn.DataTable.isDataTable('#dt_admin_pic')) {
                            $('#dt_admin_pic').DataTable().ajax.reload();
                        } else {
                            buildPicTable();
                        }
                    } else {
                        swal('Error!', res.message || 'Gagal menambahkan PIC.', 'error');
                    }
                },
                error: function() {
                    swal('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                }
            });
        });

        if (employees_for_admin.length === 0) {
            $.ajax({
                url:      '<?= base_url('trusmi_memo/get_employees_for_admin') ?>',
                type:     'POST',
                dataType: 'json',
                success: function(data) {
                    employees_for_admin = data;
                    buildPicTable();
                },
                error: function() {
                    swal('Error!', 'Gagal memuat data karyawan.', 'error');
                }
            });
        } else {
            buildPicTable();
        }
    }

    function get_approval() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('trusmi_memo/get_approval'); ?>",
            // data: "data",
            dataType: "json",
            success: function (response) {
                approval = response;
            }
        });
    }


    function get_memo(id_memo, tipe) {
        append_approval();


        $.ajax({
            type: "POST",
            url: "<?= base_url('trusmi_memo/get_draf'); ?>",
            data: {
                id_memo: id_memo
            },
            dataType: "json",
            success: function (response) {
                $('#id_memo').val(response.id_memo);
                $('#judul').val(response.judul);
                $('#jenis').val(response.jenis);
                starter_template(response.jenis_memo);
                $('#tujuan').val(response.tujuan);
                $('#priority').val(response.priority);
                $('#category').val(response.category);
                $('#tujuan').text(response.tujuan);
                $('#approval').val(response.id_approval);
                $('#note_revisi').text(response.revisi_by_name);

                if (tinymce.get('memo-editor')) {
                    const editor = tinymce.get('memo-editor');
                    const currentContent = editor.getContent();
                    const contentToAppend = response.content || '';
                    editor.setContent(currentContent + contentToAppend);
                }
                if (response.company_id && initCompany) {
                    initCompany.setSelected(response.company_id, false);
                }

                if (response.id_approval && initApproval) {
                    initApproval.setSelected(response.id_approval);
                }

                if (initCc && response.cc && all_pic) { // Pastikan semua variabel yang dibutuhkan tersedia
                    let responseCcIds = [];
                    if (typeof response.cc === 'string') {
                        responseCcIds = response.cc.split(',').map(id => id.trim()).filter(id => id !== '');
                    } else if (Array.isArray(response.cc)) {
                        responseCcIds = response.cc;
                    }
                    const responseIdSet = new Set(responseCcIds.map(String));
                    const finalCcIds = all_pic
                        .filter(pic => responseIdSet.has(String(pic.user_id))) // Menggunakan pic.user_id
                        .map(pic => pic.user_id);
                    initCc.setSelected(finalCcIds);
                }
                const formattedData = all_pic.map(item => ({
                    text: item.nama,  // Teks yang akan ditampilkan
                    value: item.user_id    // Nilai yang akan dikirim
                }));
                const placeholder = [{ text: '', placeholder: true }];
                const finalData = placeholder.concat(formattedData);

                // Mengisi data ke setiap instance SlimSelect
                initDiverifikasi.setData(finalData);
                initDisetujui.setData(finalData);
                initMengetahui.setData(finalData);
                // if (all_pic) {
                // }

                loadDepartments(response.company_id, function () {
                    let departmentIds = [];
                    if (response.department_id && typeof response.department_id === 'string') {
                        departmentIds = response.department_id.split(',').filter(id => id);
                    }
                    initDepartment.setSelected(departmentIds, false);
                    loadToperson(response.department_id, function () {
                        let user_to_id = [];
                        if (response.to_person && typeof response.to_person === 'string') {
                            user_to_id = response.to_person.split(',').filter(id => id);
                        }
                        initToperson.setSelected(user_to_id);
                    });
                });
                // console.log(response.to_person);

                // loadToperson(response.department_id, (response.to_person ? response.to_person.split(',') : []));


                const fileInput = $('#file_memo');
                const fileInfo = $('#file-info');
                const currentFileLink = $('#current-file-link');
                const existingFileInput = $('#existing_file');

                if (response.lampiran) {
                    currentFileLink.text(response.lampiran);
                    currentFileLink.attr('href', '<?= base_url('uploads/files_memo/') ?>' + response.lampiran);
                    existingFileInput.val(response.lampiran);
                    fileInfo.show();
                    fileInput.hide();
                } else {
                    fileInfo.hide();
                    fileInput.show();
                    existingFileInput.val('');
                }

                if (initRole) {
                    let roleIds = [];
                    if (response.role_id && typeof response.role_id === 'string') {
                        roleIds = response.role_id.split(',').filter(id => id);
                    }
                    initRole.setSelected(roleIds); // Mengirim array ke komponen
                }
                $('#modal_add_memo').modal('show');
                if (tipe == 1) {// jika di draf
                    $('#modal_data_memo').modal('hide');
                    $('#label_form_memo').text('Form Memo');
                    $('#btn_draf').show();
                    $('.row_revisi').hide();
                    $('#id_revisi').val(null);
                } else { //jika di revisi
                    $('.row_revisi').show();
                    $('#id_revisi').val(response.id_revisi);
                    $('#label_form_memo').text('Form Memo Revisi');
                    $('#btn_draf').hide();


                }
            }
        });
    }

    $('#company_id').change(function (e) {
        e.preventDefault();
        company_id = $(this).val();
        const newHeaderUrl = $(this).find(':selected').data('header');
        loadDepartments(company_id);
        if (!newHeaderUrl) {
            // console.log('Tidak ada data-header pada option yang dipilih.');
            return;
        }
        const editor = tinymce.get('memo-editor');
        if (editor) {
            const editorDocument = editor.getDoc();
            header_memo = newHeaderUrl;
            $(editorDocument).find('body').css('background-image', `url(${newHeaderUrl})`);
            // console.log(`Header diubah menjadi: ${newHeaderUrl}`);
        } else {
            // console.error('Editor TinyMCE belum siap atau tidak ditemukan.');
        }
    });
    $('#department_id').change(function (e) {
        e.preventDefault();
        value = $(this).val();
        const newHeaderUrl = $(this).find(':selected').data('header');
        loadToperson(value);
        const editor = tinymce.get('memo-editor');
        if (editor) {
            const editorDocument = editor.getDoc();
            if (newHeaderUrl) {
                header_memo = newHeaderUrl;
                $(editorDocument).find('body').css('background-image', `url(${newHeaderUrl})`);
                // console.log(`Header diubah menjadi: ${newHeaderUrl}`);
            } else {
                // Jika TIDAK ADA header, hapus background image yang mungkin ada sebelumnya
                // $(editorDocument).find('body').css('background-image', 'none');
                // console.log('Header dihapus karena opsi yang dipilih tidak memiliki data-header.');
            }
        } else {
            // console.error('Editor TinyMCE belum siap atau tidak ditemukan.');
        }

    });


    function approve_memo(id_approval, id_memo, judul, category, ttd_digital) {
        $('#modal_approve').modal('show');
        $('.app_id_approval').val(id_approval);
        $('.app_id_memo').val(id_memo);
        $('.app_judul').val(judul);
        $('.app_category').val(category);
        $('.app_ttd_digital').val(ttd_digital);
    }
    function approve_memo_sekdir(id_approval, id_memo, judul, category, ttd_digital) {
        $('#modal_approve_sekdir').modal('show');
        $('.app_id_approval').val(id_approval);
        $('.app_id_memo').val(id_memo);
        $('.app_judul').val(judul);
        $('.app_category').val(category);
        $('.app_ttd_digital').val(ttd_digital);
    }

    $('#form-approval').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var ttd = $('.app_ttd_digital').val();
        var status = $('#approval_status').val();

        if (ttd == 'null' && status == 1) {
            swal('Opps!', 'Silahkan bubuhkan Ttd digital terlebih dahulu di Dashboard Trusmiverse!', 'error');
            return;
        }
        swal({
            title: "Confirm!",
            text: "Anda Yakin dengan perubahan ini?",
            icon: "info",
            buttons: true,
            dangerMode: false,
        })
            .then((simpan) => {
                if (simpan) {
                    $.ajax({
                        'url': "<?= base_url('trusmi_memo/form_approve') ?>",
                        'type': "POST",
                        'data': form.serialize(),
                        'dataType': "JSON",
                        'success': function (response) {
                            console.log(response);
                            swal('Success!', 'Berhasil Approve Memo', 'success');
                            $('#modal_approve').modal('hide');
                            $('#dt_memo_modal').DataTable().ajax.reload();
                            $('#dt_memo').DataTable().ajax.reload();

                        }
                    })
                }
            });
    });
    $('#form-approval-sekdir').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var ttd = $('.app_ttd_digital').val();
        var status = $('#approval_status_sekdir').val();

        if (ttd == null && status == 1) {
            swal('Opps!', 'Silahkan bubuhkan Ttd digital terlebih dahulu di Dashboard Trusmiverse!', 'error');
            return;
        }

        swal({
            title: "Confirm!",
            text: "Anda Yakin dengan perubahan ini?",
            icon: "info",
            buttons: true,
            dangerMode: false,
        })
            .then((simpan) => {
                if (simpan) {
                    $.ajax({
                        url: "<?= base_url('trusmi_memo/form_approve_sekdir') ?>",
                        type: "POST",
                        data: form.serialize(),
                        dataType: "JSON",
                        beforeSend: function () {
                            swal({
                                title: "Loading...",
                                text: "Sedang memproses data",
                                buttons: false,
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                content: {
                                    element: "div",
                                    attributes: {
                                        innerHTML: "<div class='spinner-border text-info' role='status'><span class='sr-only'>Loading...</span></div>"
                                    }
                                }
                            });
                        },
                        success: function (response) {
                            swal('Success!', 'Berhasil Approve Memo', 'success');
                            $('#modal_approve_sekdir').modal('hide');
                            $('#dt_memo_modal').DataTable().ajax.reload();
                            $('#dt_memo').DataTable().ajax.reload();
                        },
                        error: function () {
                            swal('Error!', 'Terjadi kesalahan saat memproses data.', 'error');
                        },
                        complete: function () {
                            // swal akan diganti oleh success/error
                        }
                    });
                }
            });
    });

    $('#approval_status').on('change', function () {
        if ($(this).val() === 'revisi') {
            // Jika memilih "Revisi", tampilkan kolom catatan
            $('#kolom_catatan_revisi').slideDown();
        } else {
            // Jika memilih "Approve", sembunyikan
            $('#kolom_catatan_revisi').slideUp();
        }
    });

    // 2. Logika untuk menampilkan/menyembunyikan jadwal publish
    $('#publish_sekarang').on('change', function () {
        if (this.checked) {
            // Jika checkbox dicentang, sembunyikan pilihan tanggal
            $('#kolom_jadwal_publish').slideUp();
        } else {
            // Jika tidak dicentang, tampilkan pilihan tanggal
            $('#kolom_jadwal_publish').slideDown();
        }
    });

    // 3. (Opsional) Reset form saat modal ditutup
    $('#modal_approve').on('hidden.bs.modal', function () {
        $('#form-approval')[0].reset(); // Reset semua input

        // Kembalikan ke kondisi awal
        $('#kolom_catatan_revisi').hide();
        $('#kolom_jadwal_publish').hide();
        $('#approval_status').val('approve'); // Set default ke approve
    });
    $('#btn_submit_approval').on('click', function () {
        var formData = new FormData($('#form-approval')[0]);
        if ($('#publish_sekarang').is(':checked')) {
            formData.set('publish_datetime', 'now');
        }

        console.log("Data yang akan dikirim:");
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }


    });

    function resetMemoForm() {
        const modal = $('#modal_add_memo');

        modal.find('input[type="text"], textarea').val('');
        modal.find('input[type="hidden"]:not(#id_memo)').val(''); // Reset semua hidden kecuali id_memo
        modal.find('#id_memo').val('null'); // Kembalikan id_memo ke nilai default 'null'
        modal.find('#id_approval').val(null); // Kembalikan id_memo ke nilai default 'null'


        if (window.initCompany) initCompany.setSelected('');
        if (window.initDepartment) initDepartment.setSelected([]); // Gunakan array kosong untuk multi-select
        if (window.initRole) initRole.setSelected([]);      // Gunakan array kosong untuk multi-select
        if (window.initApproval) initApproval.setSelected('');
        if (window.initPriority) initPriority.setSelected('');
        if (window.initCategory) initCategory.setSelected('');
        if (window.initCc) initCc.setSelected('');

        modal.find('#file-info').hide(); // Sembunyikan div info file lama
        modal.find('#current-file-link').text('').attr('href', '#'); // Hapus teks & link file lama
        modal.find('#existing_file').val(''); // Kosongkan hidden input file lama
        modal.find('#file_memo').val('').show(); // Tampilkan & kosongkan input file utama

        // 5. Kembalikan ke Tab pertama (Detail Memo) untuk pengalaman pengguna yang lebih baik
        const firstTab = new bootstrap.Tab(document.querySelector('#detail-tab'));
        firstTab.show();

        // 6. Hapus kelas validasi error jika ada
        modal.find('.is-invalid').removeClass('is-invalid');
        modal.find('.invalid-feedback').hide();
    }

    $('#remove-file-btn').on('click', function () {
        // Sembunyikan info file
        $('#file-info').hide();
        // Kosongkan input hidden
        $('#existing_file').val('');
        // Tampilkan kembali input file dan kosongkan nilainya
        $('#file_memo').val('').show();
    });


    function add_approval() {
        $('#form_add_approval')[0].reset();
        $('#modal_add_approval').modal('show');

    }
    $('#form_add_approval').submit(function (e) {
        e.preventDefault();
        const diverifikasiValues = initDiverifikasi.getSelected();
        const disetujuiValues = initDisetujui.getSelected();
        const mengetahuiValues = initMengetahui.getSelected();

        // 2. Lakukan validasi
        // Cek apakah semua array dari SlimSelect kosong
        if (diverifikasiValues.length === 0 && disetujuiValues.length === 0 && mengetahuiValues.length === 0) {
            swal('Opps!', 'Harap pilih minimal satu orang PIC untuk approval (Diverifikasi, Disetujui, atau Mengetahui).', 'error');
            return; // Menghentikan eksekusi fungsi lebih lanjut
        }
        var formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url("trusmi_memo/form_add_approval") ?>', // Ganti dengan URL controller Anda
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    swal('Success!', 'Berhasil Update data!', 'success');
                    $('#modal_add_approval').modal('hide');
                    get_approval();
                    setTimeout(function () {
                        append_approval();
                    }, 1000);
                }

            },
            error: function () {
                alert('Terjadi kesalahan saat menghubungi server.');
            }
        });

    });

    function populateSlimSelects(data) {
        const formattedData = data.map(item => ({
            text: item.nama,  // Teks yang akan ditampilkan
            value: item.user_id    // Nilai yang akan dikirim
        }));
        const placeholder = [{ text: '', placeholder: true }];
        const finalData = placeholder.concat(formattedData);

        // Mengisi data ke setiap instance SlimSelect
        initDiverifikasi.setData(finalData);
        initDisetujui.setData(finalData);
        initMengetahui.setData(finalData);
        initCc.setData(finalData);

        // console.log("Semua dropdown SlimSelect telah di-update.");
    }
    // $('#approval').change(function (e) {
    //     e.preventDefault();
    //     const selectedId = $(this).val();
    //     console.log($(this).data('nama_dibuat'));


    //     if (selectedId) {
    //         // 2. Cari objek data yang cocok di dalam array Anda
    //         // const selectedData = formattedApprovalData.find(item => item.value == selectedId);

    //         // 3. Jika data ditemukan, set nilai inputnya
    //         // if (selectedData) {
    //         $('#dibuat').val($(this).data('nama_dibuat'));
    //         $('#diverifikasi').val($(this).data('nama_deverifikasi'));
    //         $('#disetujui').val($(this).data('nama_disetujui'));
    //         $('#mengetahui').val($(this).data('nama_mengetahui'));
    //         // }
    //     } else {
    //         // Jika tidak ada yang terpilih, kosongkan input
    //         $('#dibuat').val('');
    //         $('#diverifikasi').val('');
    //         $('#disetujui').val('');
    //         $('#mengetahui').val('');
    //     }
    // });

    document.addEventListener('click', function (event) {

        // Cari elemen dengan class 'copy-link-btn' yang paling dekat dengan target klik
        const copyBtn = event.target.closest('.copy-link-btn');

        // Jika tombol copy ditemukan
        if (copyBtn) {
            event.preventDefault(); // Mencegah perilaku default

            const urlToCopy = copyBtn.dataset.url; // Ambil URL dari atribut data-url
            const originalContent = copyBtn.innerHTML; // Simpan konten asli tombol

            // Gunakan Clipboard API modern untuk menyalin teks
            navigator.clipboard.writeText(urlToCopy).then(() => {
                // Jika berhasil, beri feedback ke pengguna
                copyBtn.innerHTML = '<i class="bi bi-check-lg"></i> Copied!';
                copyBtn.classList.remove('bg-primary');
                copyBtn.classList.add('bg-success');

                // Kembalikan ke teks semula setelah 2 detik
                setTimeout(() => {
                    copyBtn.innerHTML = originalContent;
                    copyBtn.classList.remove('bg-success');
                    copyBtn.classList.add('bg-primary');
                }, 2000);

            }).catch(err => {
                // Jika gagal, tampilkan pesan error di console
                console.error('Gagal menyalin link: ', err);
                alert('Oops, gagal menyalin link.');
            });
        }
    });

    function simpan_memo() {
        let form_data = new FormData();
        tipe_memo = $('#tipe_memo').val();
        note = $('#note').val();
        file_memo = $('#file_memo').val();
        company_id = $('#company_id').val();
        department_id = $("#department_id").val().toString().split(",");
        role_id = $("#role_id").val().toString().split(",");
        files = $("#file_memo").prop("files")[0];
        form_data.append("files", files);
        form_data.append("tipe_memo", tipe_memo);
        form_data.append("note", note);
        form_data.append("company_id", company_id);
        form_data.append("department_id", department_id);
        form_data.append("role_id", role_id);
        if (tipe_memo == null) {
            swal('Warning!', 'Harap memilih tipe memo', 'error');
        } else if (note == '') {
            swal('Warning!', 'Harap mengisi note', 'error');
        } else if (company_id == '') {
            swal('Warning!', 'Harap memilih Company', 'error');
        } else if (department_id == '') {
            swal('Warning!', 'Harap memilih Department', 'error');
        } else if (role_id == '') {
            swal('Warning!', 'Harap memilih Role/Jabatan', 'error');
        } else if (file_memo == '') {
            swal('Warning!', 'Harap mengupload file memo', 'error');
        } else {
            swal({
                title: "Simpan Memo?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
                .then((simpan) => {
                    if (simpan) {
                        $.ajax({
                            'url': "<?= base_url('memo/simpan_memo') ?>",
                            'type': "POST",
                            'data': form_data,
                            'dataType': "JSON",
                            'processData': false, // Prevent jQuery from processing the data
                            'contentType': false, // Prevent jQuery from setting the content type
                            'beforeSend': function () {
                                // $('#spinner').modal('show');
                                $("#btn_save").attr("disabled", true);
                            },
                            'success': function (response) {
                                console.log(response);
                                if (response.insert_memo) {
                                    // $('#spinner').modal('hide');
                                    $('#modal_add_memo').modal('hide');
                                    $("#btn_save").removeAttr("disabled");
                                    $('#dt_memo').DataTable().ajax.reload();
                                    swal('Success!', 'Berhasil menambah memo', 'success');
                                } else {
                                    $("#btn_save").removeAttr("disabled");
                                    swal('Warning!', 'Gagal menambah memo ', 'error');
                                }

                            }
                        })
                    }
                });
        }
    }

    function change_status(memo) {
        id = $(memo).data('id_memo');
        note = $(memo).data('note');
        role = $(memo).data('role');
        department = $(memo).data('department');
        company = $(memo).data('company');
        $('#edit_id_memo').val(id);
        $('#edit_note').val(note);
        $('#edit_role').val(role);
        $('#edit_department').val(department);
        $('#edit_company').val(company);
        $('#note_update').val('');
        $('#status_memo').val('#');
        $('#modal_edit_memo').modal('show');
    }

    function edit_memo() {
        note = $('#note_update').val();
        status = $('#status_memo').val();
        id = $('#edit_id_memo').val();

        if (status == null) {
            swal('Warning!', 'Harap memilih status', 'error');
        } else if (note == '') {
            swal('Warning!', 'Harap mengisi note update', 'error');
        } else {
            $.ajax({
                url: "<?= base_url('memo/edit_memo') ?>",
                method: "POST",
                data: {
                    note: note,
                    status: status,
                    id: id
                },
                dataType: "JSON",
                beforeSend: function () {
                    // $('#spinner').modal('show');
                    $("#btn_edit_memo").attr("disabled", true);
                },
                success: function (res) {
                    console.log(res);
                    // $('#spinner').modal('hide');
                    $('#modal_edit_memo').modal('hide');
                    $('#modal_waiting_memo').modal('hide');
                    $("#btn_edit_memo").removeAttr("disabled");
                    swal('Success!', 'Berhasil mengubah status memo', 'success');
                    $('#dt_memo').DataTable().ajax.reload();
                    $('#list_waiting').DataTable().ajax.reload();
                }
            })
        }
    }

    const formatDate = (dateString) => {
        const options = {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        };
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', options);
    };

    function add_feedback(id) {
        $('#id_memo_feedback').val(id);
        $('#feedback').summernote('code', '');
        $('#form_feedback')[0].reset();
        $('#modal_add_feedback_memo').modal('show');
        $.ajax({
            url: "<?= base_url('memo/feedback_memo_history') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            beforeSend: function () {
                $('#history_feedback').html('')
            },
            success: function (res) {
                var data = res.histories
                var history = ``;
                $.each(data, function (i, val) {
                    history += `<tr>
                        <td>
                            ${formatDate(val.feedback_at)}
                        </td>
                        <td>
                            ${val.feedback}
                        </td>
                        <td>${val.file_feedback != null ? `<a href="<?= base_url("uploads/files_memo/feedback/") ?>${val.file_feedback}" target="_blank">Download File</a>` : ''}</td>
                        <td>${val.link_feedback != null ? `<a href="${val.link_feedback}" target="_blank">Go to Link</a>` : ''}</td>
                        <td>${val.status_feedback}</td>
                        <td>${val.feedback_by}</td>
                    </tr>`
                })
                $('#history_feedback').html(history)
            }
        })
    }



    function change_file_memo(id) {
        $('#id_memo_file').val(id);
        $('#change_file_memo').val('');
        $('#form_change_file_memo')[0].reset();
        $('#modal_change_file_memo').modal('show');
    }

    function edit_file_memo() {
        let form_data = new FormData();
        id = $('#id_memo_file').val();
        file_memo = $('#change_file_memo').val();
        files = $("#change_file_memo").prop("files")[0];
        form_data.append("files", files);
        form_data.append("id", id);
        if (file_memo == '') {
            swal('Warning!', 'Harap mengupload file memo', 'error');
        } else {
            swal({
                title: "Simpan File Memo?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
                .then((simpan) => {
                    if (simpan) {
                        $.ajax({
                            'url': "<?= base_url('memo/edit_file_memo') ?>",
                            'type': "POST",
                            'data': form_data,
                            'dataType': "JSON",
                            'processData': false, // Prevent jQuery from processing the data
                            'contentType': false, // Prevent jQuery from setting the content type
                            'beforeSend': function () {
                                // $('#spinner').modal('show');
                                $("#btn_save_file").attr("disabled", true);
                            },
                            'success': function (response) {
                                console.log(response);
                                if (response.update) {
                                    // $('#spinner').modal('hide');
                                    $('#modal_change_file_memo').modal('hide');
                                    $("#btn_save_file").removeAttr("disabled");
                                    $('#dt_memo').DataTable().ajax.reload();
                                    swal('Success!', 'Berhasil mengubah file memo', 'success');
                                } else {
                                    $("#btn_save_file").removeAttr("disabled");
                                    swal('Warning!', 'Gagal mengubah file memo ', 'error');
                                }

                            }
                        })
                    }
                });
        }
    }
</script>