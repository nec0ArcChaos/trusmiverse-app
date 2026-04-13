<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>





<script>
    $(document).ready(function () {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dt_fack(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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



    });


    function addLetterAfter2Chars(sentence) {
        let result = '';
        for (let i = 0; i < sentence.length; i++) {
            result += sentence[i];
            if ((i + 1) % 2 === 0) {
                result += String.fromCharCode(97 + Math.floor(Math.random() * 26)) + String.fromCharCode(97 + Math.floor(Math.random() * 26)); // Menambahkan karakter acak setelah setiap 2 karakter
            }
        }
        return result.toUpperCase();
    }


    $('#resignation_date').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
        // uiLibrary: 'bootstrap4'
    });

    function dt_fack(start, end) {
        let user_id = "<?= $this->session->userdata("user_id"); ?>";
        let user_role_id = "<?= $this->session->userdata("user_role_id"); ?>";

        // var table = $('#dt_trusmi_resignation').DataTable();


        $('#dt_fack').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>fack/dt_fack",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            {
                "data": "date_of_joining",
                // "render": function(data, type, row) {
                //     return `<?= date('d-m-Y', strtotime('${row.date_of_joining}')) ?>`
                // },
            },
            {
                "data": "job_title",
                "className": "d-none d-md-block",
                "render": function (data, type, row) {
                    if (row['type'] == "") {
                        type = "";
                    } else {
                        if (row['type'] == 'Sales Inhouse') {
                            type = `&nbsp;<span class="badge bg-light-orange text-orange">${row['type']}</span>`;
                        } else {
                            type = `&nbsp;<span class="badge bg-light-teal text-teal">${row['type']}</span>`;
                        }
                    }

                    if (row['grade'] == "") {
                        grade = "";
                    } else {
                        if (row['grade'] == 'Grade A') {
                            grade = `&nbsp;<span class="badge bg-light-green text-green">${row['grade']}</span>`;
                        } else if (row['grade'] == 'Grade B') {
                            grade = `&nbsp;<span class="badge bg-light-blue text-blue">${row['grade']}</span>`;
                        } else {
                            grade = `&nbsp;<span class="badge bg-light-yellow text-yellow">${row['grade']}</span>`;
                        }
                    }

                    return data + type + grade
                }
            },
            {
                "data": "job_request_id",
            },
            {
                "data": "employee_name",
            },
            {
                "data": "company_name",
                "className": "d-none d-md-block"
            },
            // {
            //     "data": "application_id",
            //     "className": "d-none d-md-block",
            //     "render": function(data, type, row, meta) {
            //         return `https://www.trusmiverse.com/apps/fack/form/${row['application_id']}`
            //     }
            // },
            {
                "data": "is_link_expired",
                "render": function (data, type, row, meta) {
                    btn_pencil = ``
                    if (user_role_id == '1') {
                        btn_pencil = `<a role="button" onclick="btn_add_administrasi('${row['application_id']}', '${row['tgl_bersedia_gabung']}','${row['kesediaan_kendaraan']}', '${row['kesediaan_laptop']}', '${row['type']}', '${row['grade']}')" class="badge bg-warning" style="cursor:pointer;"><i class="bi bi-pencil-square"></i></a>`
                    }
                    if (row['company_id'] != 3 && user_id == '3648') {
                        btn_pencil = ``
                    }
                    if (row['is_link_expired'] == 1) {
                        if (!row['user_id']) {
                            registrasi_karyawan = `
                        ${btn_pencil}
                        <a href="<?= base_url() ?>fack/detail/${row['application_id']}" target="_blank" class="badge bg-info" style="cursor:pointer;"><i class="bi bi-eye"></i></a>`
                        } else {
                            registrasi_karyawan = `<span class="badge bg-primary">Registered</span> <a href="<?= base_url() ?>fack/detail/${row['application_id']}" target="_blank" class="badge bg-info" style="cursor:pointer;"><i class="bi bi-eye"></i></a> <a role="button" onclick="send_user_absen_fdk('${row['employee_id']}')" class="badge bg-danger" style="cursor:pointer;"><i class="bi bi-send"></i> Aktivasi</a> `
                        }
                        status = `<span class="badge bg-success">Done</span> ${registrasi_karyawan}  `
                    } else {
                        status = `<span class="badge bg-warning">Progress</span> 
                    <a href="<?= base_url() ?>fack/detail/${row['application_id']}" target="_blank" class="badge bg-info" style="cursor:pointer;"><i class="bi bi-eye"></i></a> 
                    <a role="button" onclick="send_ulang_fack('${row['application_id']}')" class="badge bg-secondary" style="cursor:pointer;"><i class="bi bi-send"></i></a> 
                    
                    `
                    }
                    return status
                },
            },
            ],
            "createdRow": function (row, data, dataIndex) {
                // 
            }
        });
    }

    // Add event listener for opening and closing details
    $('#dt_fack tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = $('#dt_fack').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(dt_detail_fack(row.data())).show();
            tr.addClass('shown');
        }
    });

    function dt_detail_fack(d) {
        // `d` is the original data object for the row
        return (
            `
                        <table class="table table-sm table-striped" style="table-layout:fixed;">
                        <tbody>
                        <tr><td colspan="2"><b>A. Personal Details</b></td></tr>
                        <tr><td><b>Application Id</b></td><td>${d.application_id}</td></tr>
                        <tr><td><b>Link Input F.R.C.K</b></td><td>https://www.trusmiverse.com/apps/fack/form/${addLetterAfter2Chars(d.application_id)}</td></tr>
                        <tr><td><b>Posisi</b></td><td>${d.job_title}</td></tr>
                        <tr><td><b>Company</b></td><td>${d.company_name}</td></tr>
                        <tr><td><b>Pas Foto</b></td><td><a href="<?= base_url() ?>uploads/fack/pas_foto/${d.pas_foto}" target="blank">Lihat Foto</a></td></tr>
                        <tr><td><b>Nama Kandidat</b></td><td>${d.employee_name}</td></tr>
                        <tr><td><b>No. NPWP</b></td><td>${d.no_npwp}</td></tr>
                        <tr><td><b>No. KTP</b></td><td>${d.no_ktp}</td></tr>
                        <tr><td><b>TTL</b></td><td>${d.tempat_lahir}, ${d.tgl_lahir}</td></tr>
                        <tr><td><b>JK</b></td><td>${d.gender}</td></tr>
                        <tr><td><b>Status</b></td><td>${d.status}</td></tr>
                        <tr><td><b>Agama</b></td><td>${d.agama}</td></tr>
                        <tr><td><b>Kewarganegaraan</b></td><td>${d.kewarganegaraan}</td></tr>
                        <tr><td><b>Almt KTP</b></td><td>${d.alamat_ktp}</td></tr>
                        <tr><td><b>Almt saat ini</b></td><td>${d.alamat_saat_ini}</td></tr>
                        <tr><td><b>No. Telp</b></td><td>${d.no_hp}</td></tr>
                        <tr><td><b>Email</b></td><td>${d.email}</td></tr>
                        <tr><td><b>Kendaraan</b></td><td>${d.ctm_kendaraan}</td></tr>
                        <tr><td><b>Laptop Pribadi</b></td><td>${d.ctm_laptop}</td></tr>
                        <tr><td><b>Fasilitas Mess</b></td><td>${d.ctm_mess}</td></tr>
                        <tr><td><b>Fasilitas Mess</b></td><td>${d.ctm_mess}</td></tr>
                        <tr><td><b>Keterangan Offering</b></td><td>${d.keterangan}</td></tr>
                        </tbody>
                        </table>
                        `
        );
    }

    function send_ulang_fack(application_id) {
        $.confirm({
            title: 'Prompt!',
            type: 'blue',
            theme: 'material',
            content: 'Apakah anda yakin resend notif F.R.C.K ?',
            buttons: {
                cancel: function () {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function () { }
                                },
                            },
                            onOpen: function () {
                                $.ajax({
                                    url: `<?= base_url() ?>fack/send_fack_to_karyawan/${application_id}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    beforeSend: function () {

                                    },
                                    success: function (response) { },
                                    error: function (xhr) { },
                                    complete: function () { },
                                }).done(function (response) {
                                    dt_fack();
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Done!',
                                            theme: 'material',
                                            type: 'blue',
                                            content: 'Resend notif!',
                                            buttons: {
                                                close: {
                                                    actions: function () { }
                                                },
                                            },
                                        });
                                    }, 250);
                                }).fail(function (jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal Resend Notif!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function () { }
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
        });
    }

    function btn_add_administrasi(application_id, tgl_bersedia_gabung, kesediaan_kendaraan, kesediaan_laptop, type, grade) {
        $.confirm({
            title: 'Prompt!',
            type: 'blue',
            theme: 'material',
            columnClass: 'xlarge',
            scrollToPreviousElement: false, // add this line 
            scrollToPreviousElementAnimate: false, // add this line 
            useBootstrap: true,
            offsetTop: 40,
            offsetBottom: 40,
            content: function () {
                var self = this;
                return $.ajax({
                    url: '<?= base_url() ?>fack/get_administrasi_need',
                    dataType: 'json',
                    method: 'POST'
                }).done(function (response) {

                    let opt_company = '<option value="">Pilih Company</option>'; // <-- PERUBAHAN DI SINI
                    if (response.company) { // <-- PERUBAHAN DI SINI
                        for (let index = 0; index < response.company.length; index++) {
                            opt_company += `<option value="${response.company[index].company_id}">${response.company[index].name}</option>`;
                        }
                    }
                    opt_des = '';
                    for (let index = 0; index < response.designation.length; index++) {
                        opt_des += `<option value="${response.designation[index].id_designation_administrasi}">${response.designation[index].designation_administrasi}</option>`;
                    }
                    opt_shift = '';
                    for (let index = 0; index < response.office_shifts.length; index++) {
                        opt_shift += `<option value="${response.office_shifts[index].office_shift_id}">${response.office_shifts[index].shift_name}</option>`;
                    }
                    opt_user_roles = '';
                    for (let index = 0; index < response.user_roles.length; index++) {
                        opt_user_roles += `<option value="${response.user_roles[index].role_id}">${response.user_roles[index].role_name}</option>`;
                    }
                    opt_leaves_type = '';
                    for (let index = 0; index < response.leaves_type.length; index++) {
                        opt_leaves_type += ` 
                        <div class="form-check">
                        <input class="form-check-input leave_categoriesCheckbox" type="checkbox" value="${response.leaves_type[index].leave_type_id}" name="leave_categories[]" id="leave_categories${index}" style="cursor:pointer;" checked>
                        <label class="form-check-label" for="leave_categories${index}" style="cursor:pointer;">
                        ${response.leaves_type[index].type_name}
                        </label>
                        </div>`
                    }
                    opt_location = '';
                    for (let index = 0; index < response.location.length; index++) {
                        opt_location += `<option value="${response.location[index].location_id}">${response.location[index].location_name}</option>`;
                    }
                    opt_pt = '';
                    for (let index = 0; index < response.pt.length; index++) {
                        opt_pt += `<option value="${response.pt[index].id_pt}">${response.pt[index].nama_pt}</option>`;
                    }
                    opt_als = '';
                    for (let index = 0; index < response.alasan.length; index++) {
                        opt_als += `<option value="${response.alasan[index].id}">${response.alasan[index].reason}</option>`;
                    }
                    self.setContent(`
                        <form action="" id="form-fack-pendidikan" class="col-12">
                        <div class="row col-12">
                        <div class="mb-2 col-12">
                        <input type="hidden" name="application_id" id="application_id" value="${application_id}" readonly>
                        <input type="hidden" name="type" id="type" value="${type}" readonly>
                        <input type="hidden" name="grade" id="grade" value="${grade}" readonly>
                        </div>
                        <div class="mb-2 col-4 col-md-4">
                        <label for="company_name" class="form-label-custom required">Company</label>
                        <select id="company_name" name="company_name" class="wide mb-2 custom-style company_name">
                            ${opt_company}
                        </select>
                        </div>
                        <div class="mb-2 col-4 col-md-4">
                        <label for="department_name" class="form-label-custom required">Department Name</label>
                        <select id="department_name" name="department_name" class="wide mb-2 custom-style department_name">

                        </select>
                        </div>

                        <div class="mb-2 col-4 col-md-4">
                        <label for="designation_name" class="form-label-custom required">Designation</label>
                        <select id="designation_name" name="designation_name" class="wide mb-2 custom-style designation_name">
                        </select>
                        </div>
                        
                        <div class="mb-2 col-12 col-md-12 d-none">
                        <label for="designation_administrasi" class="form-label-custom required">Designation, Department, Company</label>
                        <select id="designation_administrasi" name="designation_administrasi" class="wide mb-2 custom-style designation_administrasi">
                        ${opt_des}
                        </select>
                        </div>
                        <div class="mb-2 col-12 col-md-4">
                        <label for="kesediaan_kendaraan" class="form-label-custom required">Kendaraan</label>
                        <textarea name="kesediaan_kendaraan" class="form-control border-custom" id="kesediaan_kendaraan" cols="30" rows="3">${kesediaan_kendaraan}</textarea>
                        </div>
                        <div class="mb-2 col-12 col-md-4">
                        <label for="kesediaan_laptop" class="form-label-custom required">Laptop Pribadi</label>
                        <textarea name="kesediaan_laptop" class="form-control border-custom" id="kesediaan_laptop" cols="30" rows="3">${kesediaan_laptop}</textarea>
                        </div>
                        <div class="mb-2 col-12 col-md-4">
                        <label for="kesediaan_mess" class="form-label-custom required">Fasilitas Mess</label>
                        <textarea name="kesediaan_mess" class="form-control border-custom" id="kesediaan_mess" cols="30" rows="3"></textarea>
                        </div>
                        <div class="mb-2 col-12 col-md-6">
                        <label for="" class="form-label-custom required">Leave Categories</label>
                        <div style="max-height:300px;overflow-y:scroll;" class="leave_categories_div">
                        ${opt_leaves_type}
                        </div>
                        <label for="keterangan" class="form-label-custom required mt-4">Keterangan Offering</label>
                        <textarea name="keterangan" class="form-control border-custom" id="keterangan" cols="30" rows="4"></textarea>
                        </div>
                        <div class="mb-2 col-12 col-md-6">
                        <div class="row">
                        <div class="mb-2 col-12">
                        <label for="status_hasil" class="form-label-custom required">Status Hasil</label>
                        <select id="status_hasil" onchange="updateKeterangan()" name="status_hasil" class="wide mb-2 custom-style" status_hasil">
                        <option value="7">Lengkap / Diterima</option>
                        <option value="8">Tidak Lengkap / Ditolak</option>
                        </select>
                        </div>
                        <div class="mb-2 col-12 col-md-12" id="alasan" style="display:none;">
                        <label for="select_alasan" class="form-label-custom required">Alasan</label>
                        <select id="select_alasan" name="select_alasan" class="wide mb-2 custom-style select_alasan">
                        ${opt_als}
                        </select>
                        </div>
                        <div class="mb-2 col-12">
                        <label for="office_shift_id" class="form-label-custom required">Office Shift</label>
                        <select id="office_shift_id" name="office_shift_id" class="wide mb-2 custom-style" office_shift_id">
                        ${opt_shift}
                        </select>
                        </div>
                        <div class="mb-2 col-12">
                        <label for="user_role_id" class="form-label-custom required">User Role</label>
                        <select id="user_role_id" name="user_role_id" class="wide mb-2 custom-style" user_role_id">
                        ${opt_user_roles}
                        </select>
                        </div>
                        <div class="mb-2 col-6">
                        <label for="location_id" class="form-label-custom required">Location</label>
                        <select id="location_id" name="location_id" class="wide mb-2 custom-style-sm" location_id">
                        ${opt_location}
                        </select>
                        </div>
                        <div class="mb-2 col-6">
                        <label for="ctm_pt" class="form-label-custom required">Afiliate PT</label>
                        <select id="ctm_pt" name="ctm_pt" class="wide mb-2 custom-style-sm ctm_pt">
                        ${opt_pt}
                        </select>
                        </div>
                        <div class="mb-4 col-12">
                        <label for="date_of_joining" class="form-label-custom required">Date Of Joining</label>
                        <input type="text" class="form-control border-custom date_of_joining tgl tanggal" name="date_of_joining" placeholder="yyyy-mm-dd" id="date_of_joining" value="${tgl_bersedia_gabung}">
                        </div>
                        <div class="mb-4 col-12">
                        <label for="date_of_joining" class="form-label-custom required">Cut Off</label>
                        <select class="wide mb-2 custom-style-sm" name="cutoff" id="cutoff">
                            <option value="1">21-20</option>
                            <option value="2">16-15</option>
                            <option value="3">01-30</option>
                        </select>
                        </div>
                        </div>
                        </div>
                        </form>`);
                    self.setTitle('Input Data Administrasi');
                }).fail(function () {
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                cancel: function () {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        let designation_administrasi = this.$content.find('#designation_administrasi').val();
                        // if (!designation_administrasi) {
                        //     $.alert('Anda belum memilih designation');
                        //     return false;
                        // }
                        let designation_name = this.$content.find('#designation_name').val();
                        if (!designation_name) {
                            $.alert('Anda belum memilih designation');
                            return false;
                        }
                        let kesediaan_kendaraan = this.$content.find('#kesediaan_kendaraan').val();
                        if (!kesediaan_kendaraan) {
                            $.alert('Anda belum memilih kesediaan kendaraan');
                            return false;
                        }
                        let kesediaan_mess = this.$content.find('#kesediaan_mess').val();
                        if (!kesediaan_mess) {
                            $.alert('Anda belum memilih kesediaan mess');
                            return false;
                        }
                        let kesediaan_laptop = this.$content.find('#kesediaan_laptop').val();
                        if (!kesediaan_laptop) {
                            $.alert('Anda belum memilih kesediaan laptop');
                            return false;
                        }
                        let status_hasil = this.$content.find('#status_hasil').val();
                        if (!status_hasil) {
                            $.alert('Anda belum memilih status hasil');
                            return false;
                        }

                        // Validasi select alasan, jika user belum memilih maka tampilkan alert
                        let select_alasan = this.$content.find('#select_alasan').val();
                        console.log(select_alasan);
                        if (!select_alasan) {
                            $.alert('Anda belum memilih alasan, silakan pilih alasan terlebih dahulu');
                            return false;
                        }

                        let keterangan = this.$content.find('#keterangan').val();
                        if (!keterangan) {
                            $.alert('Anda belum mengisi keterangan');
                            return false;
                        }
                        let date_of_joining = this.$content.find('#date_of_joining').val();
                        if (!date_of_joining) {
                            $.alert('Anda belum mengisi date of joining');
                            return false;
                        }
                        let user_role_id = this.$content.find('#user_role_id').val();
                        if (!user_role_id) {
                            $.alert('Anda belum mengisi role id');
                            return false;
                        }
                        let office_shift_id = this.$content.find('#office_shift_id').val();
                        if (!office_shift_id) {
                            $.alert('Anda belum mengisi office shift id');
                            return false;
                        }
                        let ctm_pt = this.$content.find('#ctm_pt').val();
                        if (!ctm_pt) {
                            $.alert('Anda belum mengisi ctm pt');
                            return false;
                        }
                        let location_id = this.$content.find('#location_id').val();
                        if (!location_id) {
                            $.alert('Anda belum mengisi location id');
                            return false;
                        }
                        let cutoff = this.$content.find('#cutoff').val();
                        if (!cutoff) {
                            $.alert('Anda belum mengisi cutoff');
                            return false;
                        }

                        let leave_categories = $('.leave_categoriesCheckbox:checked').map(function () {
                            return $(this).val();
                        }).get();

                        console.log(leave_categories)
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function () { }
                                },
                            },
                            onOpen: function () {
                                $.ajax({
                                    url: '<?= base_url() ?>fack/insert_administrasi',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        application_id: application_id,
                                        type: type,
                                        grade: grade,
                                        designation_administrasi: designation_name,
                                        kesediaan_kendaraan: kesediaan_kendaraan,
                                        kesediaan_mess: kesediaan_mess,
                                        kesediaan_laptop: kesediaan_laptop,
                                        status_hasil: status_hasil,
                                        date_of_joining: date_of_joining,
                                        keterangan: keterangan,
                                        leave_categories: leave_categories.sort(function (a, b) {
                                            return a - b;
                                        }).toString(),
                                        location_id: location_id,
                                        cutoff: cutoff,
                                        ctm_pt: ctm_pt,
                                        office_shift_id: office_shift_id,
                                        user_role_id: user_role_id,
                                        select_alasan: select_alasan
                                    },
                                    beforeSend: function () {

                                    },
                                    success: function (response) { },
                                    error: function (xhr) { },
                                    complete: function () { },
                                }).done(function (response) {
                                    console.log(response);
                                    if (response.status == true) {
                                        dt_fack();
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Berhasil menyimpan data administrasi karyawan!',
                                                buttons: {
                                                    close: {
                                                        actions: function () { }
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
                                            content: 'Gagal menyimpan data administrasi karyawan!',
                                            buttons: {
                                                close: {
                                                    actions: function () { }
                                                },
                                            },
                                        });
                                    }
                                }).fail(function (jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal menyimpan data administrasi karyawan!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function () { }
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
            onContentReady: function () {

                $(".tgl").mask('0000-00-00');
                $('.tanggal').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });

                $('html').css('overflow-x', 'initial');


                let status_hasil_ns = NiceSelect.bind(document.getElementById('status_hasil'), {
                    searchable: false
                });

                let select_alasan_ns = NiceSelect.bind(document.getElementById('select_alasan'), {
                    searchable: false
                });

                let designation_administrasi_ns = NiceSelect.bind(document.getElementById('designation_administrasi'), {
                    searchable: true
                });

                let department_name_ns = NiceSelect.bind(document.getElementById('department_name'), {
                    searchable: true
                });

                let company_name_ns = NiceSelect.bind(document.getElementById('company_name'), {
                    searchable: true,
                });
                let designation_name_ns = NiceSelect.bind(document.getElementById('designation_name'), {
                    searchable: true
                });

                $('#company_name').on('change', function () {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('fack/get_department'); ?>",
                        data: {
                            company_id: $(this).val()
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);

                            var $departmentSelect = $('#department_name');
                            $departmentSelect.empty();
                            $departmentSelect.append($('<option>', {
                                value: '',
                                text: 'Pilih Departemen'
                            }));

                            $.each(response, function (index, value) {
                                $departmentSelect.append($('<option>', {
                                    value: value.department_id,
                                    text: value.department_name
                                }));
                            });
                            department_name_ns.update();
                        },
                    });
                });
                $('#department_name').on('change', function () {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('fack/get_designation'); ?>",
                        data: {
                            department_id: $(this).val()
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);

                            var designation_name = $('#designation_name');
                            designation_name.empty();
                            designation_name.append($('<option>', {
                                value: '',
                                text: 'Pilih Designation'
                            }));

                            $.each(response, function (index, value) {
                                designation_name.append($('<option>', {
                                    value: value.id_designation_administrasi,
                                    text: value.designation_name
                                }));
                            });
                            designation_name_ns.update();
                        },
                    });
                });



                let location_id_ns = NiceSelect.bind(document.getElementById('location_id'), {
                    searchable: true
                });

                let office_shift_id_ns = NiceSelect.bind(document.getElementById('office_shift_id'), {
                    searchable: true
                });

                let user_role_id_ns = NiceSelect.bind(document.getElementById('user_role_id'), {
                    searchable: true
                });

                let ctm_pt_ns = NiceSelect.bind(document.getElementById('ctm_pt'), {
                    searchable: true
                });

                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    $('#company_name').change(function (e) {
        e.preventDefault();
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('fack/get_department'); ?>",
            data: {
                company_id: id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);

            }
        });
    });

    function send_user_absen_fdk(user_id){
        $.confirm({
            title: 'Prompt!',
            type: 'blue',
            theme: 'material',
            content: 'Apakah anda yakin resend notif User Absen Dan FDK ?',
            buttons: {
                cancel: function () {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function () { }
                                },
                            },
                            onOpen: function () {
                                $.ajax({
                                    url: `<?= base_url() ?>fack/send_notifikasi_aktivasi_absen_to_karyawan/${user_id}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    beforeSend: function () {

                                    },
                                    success: function (response) { },
                                    error: function (xhr) { },
                                    complete: function () { },
                                }).done(function (response) {
                                    dt_fack();
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Done!',
                                            theme: 'material',
                                            type: 'blue',
                                            content: 'Resend notif!',
                                            buttons: {
                                                close: {
                                                    actions: function () { }
                                                },
                                            },
                                        });
                                    }, 250);
                                }).fail(function (jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-chec',
                                            title: 'Success!!',
                                            theme: 'material',
                                            type: 'blue',
                                            content: 'Success dikirim',
                                            buttons: {
                                                close: {
                                                    actions: function () { }
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
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 3000,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 3000,
        });
    }

    function updateKeterangan() {
        status_hasil = $("#status_hasil").val();
        $("#alasan").hide();

        console.log($("#select_alasan").val());

        if (status_hasil == 8) {
            $("#alasan").show();
            $("#select_alasan").val('');
        }
    }

    // function printID(id) {
    //     var url = '<?= base_url('Fack/printIDCard') ?>/' + id;
    //     var windowName = 'popupWindow';
    //     var windowFeatures = 'width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes';

    //     var popupWindow = window.open(url, windowName, windowFeatures);
    //     popupWindow.focus();
    // }
</script>