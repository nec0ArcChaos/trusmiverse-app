<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
</link>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="https://trusmiverse.com/apps/assets/js/sweetalert.min.js"></script>

<script>
    const baseUrl = '<?= base_url('marcom_post'); ?>';
    $(document).ready(function() {

        // Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            }
        }, cb);

        cb(start, end);


        // ================= INIT DATATABLE =================
        let table = $('#table_marcom').DataTable({
            processing: true,
            serverSide: false,
            lengthChange: false,
            autoWidth: false,
            ajax: {
                url: baseUrl + '/list',
                type: 'GET',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [{
                    data: "title",
                },
                {
                    data: 'platform_name'
                },
                {
                    data: 'account_name'
                },
                {
                    data: 'week_number',
                    render: function(data) {
                        return 'Week ' + data;
                    }
                },
                {
                    data: 'content_type_name'
                },
                {
                    data: 'post_link',
                    render: function(data) {
                        if (!data) return '-';
                        return `<a href="${data}" 
                              target="_blank"
                              class="btn btn-sm btn-outline-primary">
                              View
                            </a>`;
                    }
                },
                {
                    data: 'target_view',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'views'
                },
                {
                    data: 'target_engagement',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'engagement'
                },
                {
                    data: 'er'
                },
                {
                    data: 'achievement'
                },
                {
                    data: 'created_by_name',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },

                // ===== ACTION COLUMN =====
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        user_id = '<?= $this->session->userdata('user_id'); ?>';
                        if (user_id == '1') {
                            return `
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning btn-edit" data-id="${data}" style="width:32px;">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${data}" style="width:32px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-info btn-rescrap" data-id="${data}" style="width:32px;">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                            `;
                        } else {
                            return `
                                <button class="btn btn-sm btn-info btn-rescrap" data-id="${data}" style="width:32px;">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                                            `;
                        }
                    }
                }
            ],
            order: [
                [5, 'desc']
            ]
        });



        // ================= FILTER BUTTON =================
        $('#btn_filter').on('click', function() {
            table.ajax.reload();
        });



        // ================= RESET BUTTON =================
        $('#btn_reset').on('click', function() {
            $('#start_date').val('');
            $('#end_date').val('');
            table.ajax.reload();
        });



        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            table.ajax.reload();
        })

        // Reset form when Input Posting button is clicked
        $('button[data-bs-target="#modalContent"]').on('click', function() {
            // Reset all form fields
            $('#contentForm')[0].reset();
            $('#content_id').val('');
            // Reset SlimSelect dropdowns
            $('#platform_select').val('').trigger('change');
            $('#account_select').html('<option value="">Pilih Akun</option>').val('').trigger('change');
            $('#week_select').val('').trigger('change');
            $('#content_type_select').val('').trigger('change');
            // Reset textarea
            $('#caption').val('');
            // Re-init SlimSelects
            if (typeof initSlimSelects === 'function') {
                initSlimSelects();
            }
        });

    });

    $('#table_marcom').on('click', '.btn-rescrap', function() {

        let id = $(this).data('id');

        $.get(baseUrl + '/get_scrap/' + id, function(res) {

            if (res.status) {

                let data = res.data;

                $('#rescrap_id').val(data.id);
                $('#rescrap_views').val(data.views);
                $('#rescrap_reach').val(data.reach);
                $('#rescrap_likes').val(data.likes);
                $('#rescrap_comments').val(data.comments);
                $('#rescrap_saves').val(data.saves);
                $('#rescrap_shares').val(data.shares);

                $('#modalRescrap').modal('show');
            }

        }, 'json');

    });

    function update_scrap() {
        // Validasi setiap inputan tidak null
        let id = $('#rescrap_id').val();
        let views = $('#rescrap_views').val();
        let reach = $('#rescrap_reach').val();
        let likes = $('#rescrap_likes').val();
        let comments = $('#rescrap_comments').val();
        let saves = $('#rescrap_saves').val();
        let shares = $('#rescrap_shares').val();

        if (!id) {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: 'ID tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        if (views === '' || views === null) {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: 'Views tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        if (reach === '' || reach === null) {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: 'Reach tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        if (likes === '' || likes === null) {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: 'Likes tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        if (comments === '' || comments === null) {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: 'Comments tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        if (saves === '' || saves === null) {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: 'Saves tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        if (shares === '' || shares === null) {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: 'Shares tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }

        $.post(baseUrl + '/update_scrap', {
            id: id,
            views: views,
            reach: reach,
            likes: likes,
            comments: comments,
            saves: saves,
            shares: shares
        }, function(res) {
            if (res.status) {
                $('#table_marcom').DataTable().ajax.reload();
                $('#modalRescrap').modal('hide');
            }
        }, 'json');
    }

    // ================= DEPENDENT DROPDOWN PLATFORM -> AKUN =================
    $('#platform_select').on('change', function() {
        let platform_id = $(this).val();
        let accountSelect = $('#account_select');

        // Jika platform kosong, kosongkan juga akun
        if (!platform_id) {
            accountSelect.html('<option value="">Pilih Akun</option>');
            initSlimSelects(); // Re-init SlimSelect
            return;
        }

        // Ambil akun dari server
        $.get(baseUrl + '/get_accounts_by_platform', {
            platform_id: platform_id
        }, function(res) {
            if (res.status) {
                let html = '<option value="">Pilih Akun</option>';

                res.data.forEach(function(item) {
                    // Format tampilan: Nama Akun (@username)
                    let usernameDisplay = item.username ? `@${item.username}` : '';
                    html += `<option value="${item.id}">${usernameDisplay}</option>`;
                });

                accountSelect.html(html);
                initSlimSelects(); // Re-init SlimSelect agar opsi baru terbaca
            }
        }, 'json');
    });

    let slimPlatform = null;
    let slimAccount = null;
    let slimWeek = null;
    let slimContentType = null;

    function initSlimSelects() {

        // PLATFORM
        if (slimPlatform) {
            slimPlatform.destroy();
        }
        slimPlatform = new SlimSelect({
            select: '#platform_select',
            placeholder: 'Pilih Platform',
            allowDeselect: true,
            closeOnSelect: true,
            contentLocation: document.getElementById('modalContent')
        });

        // ACCOUNT
        if (slimAccount) {
            slimAccount.destroy();
        }
        slimAccount = new SlimSelect({
            select: '#account_select',
            placeholder: 'Pilih Akun',
            allowDeselect: true,
            closeOnSelect: true,
            contentLocation: document.getElementById('modalContent')
        });

        // WEEK
        if (slimWeek) {
            slimWeek.destroy();
        }
        slimWeek = new SlimSelect({
            select: '#week_select',
            placeholder: 'Pilih Week',
            allowDeselect: true,
            closeOnSelect: true,
            contentLocation: document.getElementById('modalContent')
        });

        // CONTENT TYPE
        if (slimContentType) {
            slimContentType.destroy();
        }
        slimContentType = new SlimSelect({
            select: '#content_type_select',
            placeholder: 'Pilih Jenis Konten',
            allowDeselect: true,
            closeOnSelect: true,
            contentLocation: document.getElementById('modalContent')
        });
    }


    // INIT SAAT MODAL DIBUKA
    $('#modalContent').on('shown.bs.modal', function() {
        initSlimSelects();
    });


    // DELETE DATA
    $('#table_marcom').on('click', '.btn-delete', function() {

        let id = $(this).data('id');
        let btn = $(this);

        $.confirm({
            title: "Konfirmasi Hapus",
            content: "Data tidak bisa dikembalikan. Lanjutkan hapus?",
            type: "red",
            buttons: {

                hapus: {
                    text: "Hapus",
                    btnClass: "btn-red",
                    action: function() {

                        btn
                            .prop("disabled", true)
                            .html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');

                        $.post(
                            baseUrl + '/delete', {
                                id: id
                            },
                            function(res) {

                                btn
                                    .prop("disabled", false)
                                    .html('Delete');

                                if (res.status) {

                                    $.alert({
                                        title: "Berhasil",
                                        content: "Data berhasil dihapus.",
                                        type: "green"
                                    });

                                    $('#table_marcom').DataTable().ajax.reload();

                                } else {

                                    $.alert({
                                        title: "Gagal",
                                        content: res.message || "Gagal menghapus data.",
                                        type: "red"
                                    });

                                }

                            },
                            'json'
                        ).fail(function() {

                            btn
                                .prop("disabled", false)
                                .html('Delete');

                            $.alert({
                                title: "Error",
                                content: "Terjadi kesalahan server.",
                                type: "red"
                            });

                        });

                    }
                },

                batal: {
                    text: "Batal",
                    btnClass: "btn-default"
                }

            }
        });

    });

    // EDIT DATA
    $('#table_marcom').on('click', '.btn-edit', function() {

        let id = $(this).data('id');

        $.get(baseUrl + '/get_by_id/' + id, function(res) {

            if (res.status) {

                let data = res.data;

                // isi field
                $('#platform_select').val(data.platform_id);
                $('#account_select').val(data.account_id);
                $('#week_select').val(data.week_id);
                $('#content_type_select').val(data.content_type_id);

                $('input[name="post_date"]').val(data.post_date);
                $('input[name="title"]').val(data.title);
                $('input[name="post_link"]').val(data.post_link);
                $('input[name="target_view"]').val(data.target_view);
                $('input[name="views"]').val(data.views);
                $('input[name="reach"]').val(data.reach);
                $('input[name="likes"]').val(data.likes);
                $('input[name="comments"]').val(data.comments);
                $('input[name="saves"]').val(data.saves);
                $('input[name="shares"]').val(data.shares);

                $('#caption').val(data.caption);

                // simpan id ke hidden field
                $('#content_id').val(data.id);

                // refresh slimselect
                initSlimSelects();

                $('#modalContent').modal('show');

            }

        }, 'json');

    });

    let tablePlatform;

    $('#modalPlatform').on('shown.bs.modal', function() {

        if (!$.fn.DataTable.isDataTable('#table_platform')) {

            tablePlatform = $('#table_platform').DataTable({
                ajax: {
                    url: baseUrl + '/list_platform',
                    type: 'GET'
                },
                columns: [{
                        data: 'platform_name'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `
                            <button class="btn btn-sm btn-danger btn-delete-platform"
                                    data-id="${data}">
                                Delete
                            </button>
                        `;
                        }
                    }
                ]
            });

        } else {
            tablePlatform.ajax.reload();
        }

    });

    $('#table_platform').on('click', '.btn-delete-platform', function() {

        let id = $(this).data('id');

        $.confirm({
            title: 'Hapus Platform?',
            content: 'Data akan dihapus permanen.',
            type: 'red',
            buttons: {
                hapus: {
                    btnClass: 'btn-red',
                    action: function() {
                        $.post(baseUrl + '/delete_platform', {
                            id: id
                        }, function(res) {

                            if (res.status) {
                                tablePlatform.ajax.reload();
                            }

                        }, 'json');
                    }
                },
                batal: function() {}
            }
        });

    });

    let tableContentType;

    $('#modalContentType').on('shown.bs.modal', function() {

        if (!$.fn.DataTable.isDataTable('#table_content_type')) {

            tableContentType = $('#table_content_type').DataTable({
                ajax: {
                    url: baseUrl + '/list_content_type',
                    type: 'GET'
                },
                columns: [{
                        data: 'content_type_name'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `
                            <button class="btn btn-sm btn-danger btn-delete-content-type"
                                    data-id="${data}">
                                Delete
                            </button>
                        `;
                        }
                    }
                ]
            });

        } else {
            tableContentType.ajax.reload();
        }

    });

    $('#table_content_type').on('click', '.btn-delete-content-type', function() {

        let id = $(this).data('id');

        $.confirm({
            title: 'Konfirmasi Hapus',
            content: 'Jenis Konten akan dihapus.',
            type: 'red',
            buttons: {

                hapus: {
                    btnClass: 'btn-red',
                    action: function() {

                        $.post(baseUrl + '/delete_content_type', {
                                id: id
                            },
                            function(res) {

                                if (res.status) {

                                    $.alert({
                                        title: 'Berhasil',
                                        content: 'Data berhasil dihapus.',
                                        type: 'green'
                                    });

                                    tableContentType.ajax.reload();

                                }

                            }, 'json'
                        );

                    }
                },

                batal: function() {}

            }
        });

    });

    let tableAccount;

    $('#modalAccount').on('shown.bs.modal', function() {

        if (!$.fn.DataTable.isDataTable('#table_account')) {

            tableAccount = $('#table_account').DataTable({
                ajax: {
                    url: baseUrl + '/list_account',
                    type: 'GET'
                },
                columns: [{
                        data: 'platform_name'
                    },
                    {
                        data: 'account_name'
                    },
                    {
                        data: 'username',
                        render: function(data) {
                            // Tambahkan @ secara visual di tabel jika ada datanya
                            return data ? '@' + data : '-';
                        }
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `
                            <button class="btn btn-sm btn-danger btn-delete-account"
                                    data-id="${data}">
                                Delete
                            </button>
                        `;
                        }
                    }
                ]
            });

        } else {
            tableAccount.ajax.reload();
        }

    });

    $('#table_account').on('click', '.btn-delete-account', function() {

        let id = $(this).data('id');

        $.confirm({
            title: 'Konfirmasi Hapus',
            content: 'Akun akan dihapus.',
            type: 'red',
            buttons: {

                hapus: {
                    btnClass: 'btn-red',
                    action: function() {

                        $.post(baseUrl + '/delete_account', {
                                id: id
                            },
                            function(res) {

                                if (res.status) {

                                    $.alert({
                                        title: 'Berhasil',
                                        content: 'Data berhasil dihapus.',
                                        type: 'green'
                                    });

                                    tableAccount.ajax.reload();

                                }

                            }, 'json'
                        );

                    }
                },

                batal: function() {}

            }
        });

    });

    let tableWeek;

    $('#modalWeek').on('shown.bs.modal', function() {

        if (!$.fn.DataTable.isDataTable('#table_week')) {

            tableWeek = $('#table_week').DataTable({
                ajax: {
                    url: baseUrl + '/list_week',
                    type: 'GET'
                },
                columns: [{
                        data: 'week_number',
                        render: function(data) {
                            return 'Week ' + data;
                        }
                    },
                    {
                        data: 'periode'
                    },
                    {
                        data: 'start_date'
                    },
                    {
                        data: 'end_date'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `
                            <button class="btn btn-sm btn-danger btn-delete-week"
                                    data-id="${data}">
                                Delete
                            </button>
                        `;
                        }
                    }
                ]
            });

        } else {
            tableWeek.ajax.reload();
        }

    });

    $('#table_week').on('click', '.btn-delete-week', function() {

        let id = $(this).data('id');

        $.confirm({
            title: 'Konfirmasi Hapus',
            content: 'Week akan dihapus.',
            type: 'red',
            buttons: {

                hapus: {
                    btnClass: 'btn-red',
                    action: function() {

                        $.post(baseUrl + '/delete_week', {
                                id: id
                            },
                            function(res) {

                                if (res.status) {

                                    $.alert({
                                        title: 'Berhasil',
                                        content: 'Data berhasil dihapus.',
                                        type: 'green'
                                    });

                                    tableWeek.ajax.reload();
                                }

                            }, 'json'
                        );

                    }
                },

                batal: function() {}

            }
        });

    });

    // ================= SUBMIT FORM =================
    $('#contentForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#content_id').val();
        let url = id ? baseUrl + '/update' : baseUrl + '/store';

        // 1. Ambil semua value dari form
        let platform = $('select[name="platform"]').val();
        let account = $('select[name="account"]').val();
        let week = $('select[name="week"]').val();
        let contentType = $('select[name="content_type"]').val();
        let postDate = $('input[name="post_date"]').val();
        let title = $('input[name="title"]').val().trim();
        let postLink = $('input[name="post_link"]').val().trim();
        let caption = $('#caption').val().trim();

        let targetView = $('input[name="target_view"]').val();
        let views = $('input[name="views"]').val();
        let reach = $('input[name="reach"]').val();
        let likes = $('input[name="likes"]').val();
        let comments = $('input[name="comments"]').val();
        let saves = $('input[name="saves"]').val();
        let shares = $('input[name="shares"]').val();

        // 2. Buat fungsi helper untuk SweetAlert agar kode lebih rapi (TIDAK BERULANG)
        const showWarning = (message) => {
            swal({
                icon: 'warning',
                title: 'Oops...',
                text: message,
                showConfirmButton: false, // Menghilangkan tombol OK/Confirm
                timer: 2000, // Auto close setelah 2 detik (2000 ms)
                timerProgressBar: true // Menampilkan bar animasi waktu
            });
        };

        // 3. Validasi Satu Per Satu
        if (!platform) {
            showWarning("Harap memilih platform");
            return false;
        }
        if (!account) {
            showWarning("Harap memilih akun");
            return false;
        }
        if (!week) {
            showWarning("Harap memilih week");
            return false;
        }
        if (!contentType) {
            showWarning("Harap memilih jenis konten");
            return false;
        }
        if (!postDate) {
            showWarning("Harap mengisi tanggal");
            return false;
        }
        if (!title) {
            showWarning("Harap mengisi judul postingan");
            return false;
        }
        if (!caption && caption !== "") {
            showWarning("Harap mengisi caption postingan");
            return false;
        }

        if (!postLink) {
            showWarning("Harap mengisi link posting");
            return false;
        }

        if (!targetView) {
            showWarning("Harap mengisi target view");
            return false;
        }

        // Asumsi 0 adalah angka yang valid untuk Scrap, tapi jika kosong (empty string) maka ditolak
        if (views === "") {
            showWarning("Harap mengisi actual views");
            return false;
        }
        if (reach === "") {
            showWarning("Harap mengisi actual reach");
            return false;
        }
        if (likes === "") {
            showWarning("Harap mengisi actual likes");
            return false;
        }
        if (comments === "") {
            showWarning("Harap mengisi actual comments");
            return false;
        }
        if (saves === "") {
            showWarning("Harap mengisi actual saves");
            return false;
        }
        if (shares === "") {
            showWarning("Harap mengisi actual shares");
            return false;
        }

        $.post(url, $(this).serialize(), function(res) {

            if (res.status) {
                swal('Success', 'Data berhasil disimpan', 'success');
                $('#modalContent').modal('hide');
                $('#contentForm')[0].reset();
                $('#content_id').val('');
                $('#table_marcom').DataTable().ajax.reload();
            } else {
                swal('Error', 'Gagal menyimpan', 'error');
            }

        }, 'json');
    });

    function save_platform() {

        let name = $('#platform_name').val().trim();

        if (name === '') {
            swal('Warning', 'Nama Platform wajib diisi', 'warning');
            return;
        }

        $.post(baseUrl + '/store_platform', {
            platform_name: name
        }, function(res) {

            $.alert({
                title: 'Berhasil',
                content: 'Platform berhasil ditambahkan.',
                type: 'green'
            });
            $('#modalPlatform').modal('hide');
            $('#platform_name').val('');
            tablePlatform.ajax.reload();
            location.reload();

        }, 'json');
    }

    function save_content_type() {

        let name = $('#content_type_name').val().trim();

        if (name === '') {
            $.alert({
                title: 'Validasi',
                content: 'Nama Jenis Konten wajib diisi.',
                type: 'orange'
            });
            return;
        }

        $.post(baseUrl + '/store_content_type', {
                content_type_name: name
            },
            function(res) {

                if (res.status) {

                    $.alert({
                        title: 'Berhasil',
                        content: 'Jenis Konten berhasil ditambahkan.',
                        type: 'green'
                    });

                    $('#content_type_name').val('');
                    tableContentType.ajax.reload();
                    location.reload();

                } else {

                    $.alert({
                        title: 'Gagal',
                        content: res.message || 'Gagal menyimpan data.',
                        type: 'red'
                    });

                }

            }, 'json'
        );
    }

    function save_account() {

        let platform = $('#account_platform').val();
        let name = $('#account_name').val().trim();
        let username = $('#account_username').val().trim();

        if (platform === '') {
            $.alert({
                title: 'Validasi',
                content: 'Platform wajib dipilih.',
                type: 'orange'
            });
            return;
        }

        if (name === '') {
            $.alert({
                title: 'Validasi',
                content: 'Nama Akun wajib diisi.',
                type: 'orange'
            });
            return;
        }

        if (username === '') {
            $.alert({
                title: 'Validasi',
                content: 'Username wajib diisi.',
                type: 'orange'
            });
            return;
        }

        $.post(baseUrl + '/store_account', {
            platform_id: platform,
            account_name: name,
            username: username
        }, function(res) {

            if (res.status) {

                $.alert({
                    title: 'Berhasil',
                    content: 'Akun berhasil ditambahkan.',
                    type: 'green'
                });

                $('#account_name').val('');
                $('#account_username').val('');
                $('#account_platform').val('');
                tableAccount.ajax.reload();
                location.reload();

            } else {

                $.alert({
                    title: 'Gagal',
                    content: res.message || 'Gagal menyimpan data.',
                    type: 'red'
                });

            }

        }, 'json');
    }

    function save_week() {

        let weekNumber = $('#week_number').val().trim();
        let period = $('#week_period').val();
        let startDate = $('#week_start_date').val();
        let endDate = $('#week_end_date').val();

        if (weekNumber === '') {
            $.alert({
                title: 'Validasi',
                content: 'Nomor Week wajib diisi.',
                type: 'orange'
            });
            return;
        }

        if (period === '') {
            $.alert({
                title: 'Validasi',
                content: 'Periode wajib dipilih.',
                type: 'orange'
            });
            return;
        }

        if (startDate === '') {
            $.alert({
                title: 'Validasi',
                content: 'Start Date wajib diisi.',
                type: 'orange'
            });
            return;
        }

        if (endDate === '') {
            $.alert({
                title: 'Validasi',
                content: 'End Date wajib diisi.',
                type: 'orange'
            });
            return;
        }

        if (startDate > endDate) {
            $.alert({
                title: 'Validasi',
                content: 'End Date harus lebih besar dari Start Date.',
                type: 'orange'
            });
            return;
        }

        $.post(baseUrl + '/store_week', {
            week_number: weekNumber,
            period: period,
            start_date: startDate,
            end_date: endDate
        }, function(res) {

            if (res.status) {

                $.alert({
                    title: 'Berhasil',
                    content: 'Week berhasil ditambahkan.',
                    type: 'green'
                });

                $('#week_number').val('');
                $('#week_period').val('');
                $('#week_start_date').val('');
                $('#week_end_date').val('');

                tableWeek.ajax.reload();
                location.reload();

            } else {

                $.alert({
                    title: 'Gagal',
                    content: res.message || 'Gagal menyimpan data.',
                    type: 'red'
                });

            }

        }, 'json');
    }
</script>