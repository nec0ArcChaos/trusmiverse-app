<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script>
    $(document).ready(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        // alert(maxDate);
        $('#tgl_masuk').attr('min', maxDate);

        $(document).on('keyup', '.key_list', function(e) {
            if (e.which == 13) { // Kode 13 adalah key code untuk tombol enter
                e.preventDefault(); // Mencegah form dari submit default
                tambah_list(); // Memanggil fungsi tambah_list
            }
        });

        // $("#karyawan").SlimSelect({ dropdownParent: "#modal_input" });

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
        get_permintaan('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_permintaan(start, end);

        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_permintaan(start, end);
        })
        // Job Desc Text_Area
        $('#job_desc').summernote({
            placeholder: 'Job Description',
            tabsize: 2,
            height: 217,
            width: 440,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
        $('#kpi').summernote({
            placeholder: 'KPI',
            tabsize: 2,
            height: 100,
            width: 270,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
        // $('#financial').summernote({
        //     placeholder: 'Financial Impact',
        //     tabsize: 2,
        //     height: 100,
        //     width: 270,
        //     toolbar: [
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });
        // nice_select();

    });

    function get_candidates(start, end, status, table, job_id) {
        $('#' + table).DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'List Job Candidates',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>recruitment/interview/get_candidates",
                "data": {
                    start: start,
                    end: end,
                    id: status,
                    job_id: job_id
                }
            },
            "columns": [{
                    'data': 'application_id',
                    'render': function(data, type, row) {

                        return `<a href="https://trusmiverse.com/apps/recruitment/interview/detail/${row['application_id']}" target="_blank">
                                <button type = "button" class = "btn btn-warning btn-sm m-b-0-0 waves-effect waves-light"> 
                                    <i class = "bi bi-pencil" style = "color:white;" ></i>
                                </button > </a>`;

                    }
                },
                {
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        if (row['category_name'] != null) {
                            position = `${row['job_title']}<br><span class = "text-muted fs-9">${row['category_name']}</span>`;
                        } else {
                            position = `${row['job_title']}`;
                        }
                        return position;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'full_name',
                },
                {
                    'data': 'contact',
                },
                {
                    'data': 'email',
                },
                {
                    'data': 'application_status',
                    'render': function(data, type, row) {
                        status = '';
                        if (data == 3) {
                            status = '<span class="badge bg-primary">' + row['status_hasil'] + '</span>';
                        } else if (data == 6) {
                            status = '<span class="badge bg-danger">' + row['status_hasil'] + '</span>';
                        } else if (data == 5) {
                            status = '<span class="badge bg-warning">' + row['status_hasil'] + '</span>';
                        }
                        return status
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'created_at',
                },
                {
                    'data': 'status_interview',
                    'render': function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-success">Approved</span>';
                        } else if (data == 0) {
                            return '<span class="badge bg-danger">Rejected</span>';
                        } else {
                            return ''
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'tgl_interview',
                },
                {
                    'data': 'jam_interview',
                },
                {
                    'data': 'lokasi_interview',
                },
                {
                    'data': 'alasan_interview',
                },
                {
                    'data': 'is_lolos',
                    'render': function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-success">Lolos</span>';
                        } else if (data == 0) {
                            return '<span class="badge bg-danger">Gagal</span>';
                        } else {
                            return ''
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'hasil_interview',
                }
            ],
        });
    }


    $('#status_permintaan').on('change', function() {
        start = $('input[name="startdate"]').val();
        end = $('input[name="enddate"]').val();
        get_permintaan(start, end);
    })

    function get_permintaan(start, end) {
        let edit = false;
        $.ajax({
            url: "<?= base_url('recruitment/permintaan_karyawan/get_user_role') ?>",
            method: "get",
            dataType: "json",
            success: function(res) {
                if (res.edit == true) {
                    edit = true;
                }
                console.log(res);
            }
        })
        status = $('#status_permintaan').val();
        console.log(status);
        $('#dt_pk').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'List Permintaan',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>recruitment/permintaan_karyawan/list_permintaan",
                "data": {
                    status: status,
                    start: start,
                    end: end
                }
            },
            "columns": [{
                    'data': 'job_id',
                    'render': function(data, type, row) {
                        let button = `<a onclick = show_detail_modal(${row['job_id']}) target="_blank" class="btn btn-sm btn-primary me-1"><i class="bi bi-eye"></i></a>
                                    <a onclick = show_di_modal(${row['id_xin_job']}) target="_blank" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a>`;
                        if (row['id_status'] == 1 && edit == true) {
                            button += `<a onclick = show_edit_modal(${row['job_id']}) target="_blank" class="btn btn-sm btn-success"><i class="bi bi-arrow-right"></i></a>`;
                        }
                        return button
                    }
                },
                {
                    'data': 'job_title',
                    // 'render': function(data, type, row, meta) {
                    //     return `<a onclick=show_di_modal(${row['job_id']}) target="_blank" role="button" class="badge bg-blue text-white job_title" >${data}</a>`;
                    // }
                },
                {
                    'data': 'company',
                },
                {
                    'data': 'department',
                },
                {
                    'data': 'position',
                },
                {
                    'data': 'job_vacancy',

                },
                {
                    'data': 'status',
                    'render': function(data, type, row, meta) {
                        let bgColor = 'bg-blue text-white';
                        if (row['id_status'] == 1) {
                            bgColor = 'bg-yellow text-white';
                        } else if (row['id_status'] == 2) {
                            bgColor = 'bg-blue text-white';
                        } else if (row['id_status'] == 3) {
                            bgColor = 'bg-red text-white';
                        } else if (row['id_status'] == 4) {
                            bgColor = 'bg-green text-white';
                        } else if (row['id_status'] == 5) {
                            bgColor = 'bg-pink text-white';
                        }
                        return `<a role="button" class="badge . ${bgColor}" style="cursor:default;">${row['status']}</a>`;
                    }
                },
                {
                    'data': 'pic',
                },
                {
                    'data': 'alasan_reject',
                },
                {
                    'data': 'created_at',
                },
                {
                    'data': 'created',
                },
                {
                    'data': 'verified_at',
                },
                {
                    'data': 'verified',
                },
                {
                    'data': 'lt_verif',
                },
                {
                    'data': 'lt_approve',
                }
            ],
            // "createdRow": function(row, data, index) {
            //     var info = $('#dt_pk').DataTable().page.info();
            //     var rowNumber = (info.page * info.length) + (index + 1);
            //     $('td:eq(0)', row).html(rowNumber);
            // }
        });
    }

    function show_detail_modal(id) {
        status = $('#status_permintaan').val();
        let bg_header = '';
        if (status == 1) {
            bg_header = 'bg-yellow';
        } else if (status == 2) {
            bg_header = 'bg-blue';
        } else if (status == 3) {
            bg_header = 'bg-red';
        } else if (status == 4) {
            bg_header = 'bg-green';
        } else if (status == 5) {
            bg_header = 'bg-pink';
        }
        var header = $('#modal_detail_permintaan .modal-header');
        header.removeClass('bg-yellow bg-blue bg-red bg-green bg-pink');
        if (bg_header) {
            header.addClass(bg_header);
        }
        $('#modal_detail_permintaan').modal('show');
        $.ajax({
            url: "<?= base_url() ?>/recruitment/permintaan_karyawan/detail_permintaan",
            type: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                $('#detail_jabatan').text(res['permintaan'][0].job_title);
                $('#detail_jumlah').text(res['permintaan'][0].job_vacancy + ' Orang');
                $('#detail_perusahaan').text(res['permintaan'][0].company);
                $('#detail_dep').text(res['permintaan'][0].department);
                $('#detail_loc').text(res['permintaan'][0].location);
                $('#detail_kel').text(res['permintaan'][0].position);
                $('#detail_stat').html(res['permintaan'][0].job_type + ' (<i>' + res['permintaan'][0].type_contract + '</i>)');
                $('#detail_per').text(res['permintaan'][0].perencanaan);
                $('#detail_salary').text(res['permintaan'][0].salary);
                $('#detail_latar').text(res['permintaan'][0].latar_kebutuhan);
                $('#detail_kpi').text(res['permintaan'][0].kpi);
                $('#detail_finan').text(res['permintaan'][0].financial);
                $('#detail_jbl').text(res['permintaan'][0].bawahan_langsung + ' Orang');
                $('#detail_jbtl').text(res['permintaan'][0].bawahan_tidak + ' Orang');
                $('#detail_pen').text(res['permintaan'][0].pendidikan);
                $('#detail_skill').text(res['permintaan'][0].kemampuan);
                $('#detail_kompetensi').text(res['permintaan'][0].komp_kunci);
                $('#detail_kepemimpinan').text(res['permintaan'][0].komp_pemimpin);
                // Gender
                let gender = 'No Reference';
                if (res['permintaan'][0].gender == 0) {
                    gender = 'Male';
                } else if (res['permintaan'][0].gender == 1) {
                    gender = 'Female';
                }
                $('#detail_gender').text(gender);

                // Dasar Permohonan
                let permohonan = '';
                if (res['permintaan'][0].dasar == "Penggantian Untuk") {
                    permohonan = res['permintaan'][0].dasar + ' ' + res['permintaan'][0].pengganti;
                } else {
                    permohonan = res['permintaan'][0].dasar;
                }
                $('#detail_dasar').text(permohonan);
                // Latar Belakang Kebutuhan
                let desc = res['permintaan'][0].long_description;
                desc = decodeHtmlEntities(desc);
                new_desc = desc.replace(/<ol>/g, "<ul>").replace(/<\/ol>/g, "</ul>");
                $('#detail_desc').html(new_desc);
                // Pengalaman Kerja
                if (res['permintaan'][0].minimum_experience == 0) {
                    $('#detail_kerja').text('Fresh');
                } else if (res['permintaan'][0].minimum_experience == 1) {
                    $('#detail_kerja').text(res['permintaan'][0].minimum_experience + ' Year');
                } else {
                    $('#detail_kerja').text(res['permintaan'][0].minimum_experience + ' Years');
                }
            }
        })
    }
    $('#modal_add_permintaan').on('hidden.bs.modal', function() {
        // Clear input, select, and textarea values
        $(this).find('input, select, textarea').val('').prop('selected', false);
    });

    function show_edit_modal(id) {
        // $(this).find('input, select, textarea').val('').prop('selected', false);
        $('#modal_add_permintaan .modal-title').text('Edit Permintaan');
        $('#status_approve').removeAttr('hidden');
        $('#proses_permintaan').prop('disabled', false);
        $.ajax({
            url: "<?= base_url() ?>/recruitment/permintaan_karyawan/edit_permintaan",
            type: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                $('#perusahaan').html();
                $('#modal_add_permintaan').modal('show');
                // perusahaan
                let perusahaan = '';
                res.perusahaan.forEach((value, index) => {
                    if (value.last_name !== null && value.last_name !== '') {
                        perusahaan += `<option value = "${value.user_id} | ${value.company_id}"> ${value.first_name} ` + `${value.last_name} </option>`;
                    } else {
                        perusahaan += `<option value = "${value.user_id} | ${value.company_id}"> ${value.first_name} </option>`;
                    }
                })
                $('#perusahaan').html(perusahaan);
                // status
                let status_approve = ''
                res.status_approve.forEach((value, index) => {
                    if (value.id < 4) {
                        status_approve += `<option value = "${value.id}">${value.status}</option>`;
                    }
                })
                $('#status_approve').html(status_approve);
                status_approve_select.update();
                $('#perusahaan').val(`${res.permintaan.employer_id} | ${res.permintaan.company_id}`);
                perusahaan_select.update();
                get_department();
                get_location();
                get_kel_posisi();
                get_status_karyawan();
                get_tipe_kontrak();
                setTimeout(function() { //Delay mengisi value menunggu function data untuk tag select terisi
                    $('#department').val(`${res.permintaan.department_id}`);
                    department_select.update();
                    $('#location').val(res.permintaan.location_id);
                    location_select.update();
                    $('#jumlah').val(res.permintaan.job_vacancy);
                    $('#kel_posisi').val(res.permintaan.position_id);
                    kel_posisi_select.update();
                    $('#status_karyawan').val(res.permintaan.job_type);
                    status_karyawan_select.update();
                    $('#tipe_kontrak').val(res.permintaan.type_contract);
                    tipe_kontrak_select.update();
                    (res.permintaan.gender == null || res.permintaan.gender == '') ? $('#gender').val(2): $('#gender').val(res.permintaan.gender);
                    gender_select.update();
                    $('#perencanaan').val(res.permintaan.perencanaan);
                    perencanaan_select.update();
                    $('#permohonan').val(res.permintaan.dasar);
                    permohonan_select.update();
                    $('#salary').val(res.permintaan.salary);
                    $('#latar_belakang').val(res.permintaan.latar_kebutuhan);
                    $('#bawahan_lgsg').val(res.permintaan.bawahan_langsung);
                    $('#pendidikan').val(res.permintaan.pendidikan);
                    $('#bawahan_tidak_lgsg').val(res.permintaan.bawahan_tidak);
                    $('#pengalaman').val(res.permintaan.minimum_experience);
                    pengalaman_select.update();
                    $('#kemampuan').val(res.permintaan.kemampuan);
                    $('#leader_komp').val(res.kompetensi);
                    $('#key_kompetensi').val(res.permintaan.komp_kunci);
                    $('#financial').val(res.permintaan.financial);
                    $('#kpi').summernote('code', res.kpi);
                    $('#job_desc').summernote('code', res.job_desc);
                    $('#job_id').val(res.permintaan.job_id)
                }, 1000)
            }
        }).done(function(res) {
            setTimeout(function() {
                setTimeout(function() { //Delay pengisian value untuk field posisi dan pengganti
                    $('#posisi').val(`${res.permintaan.designation_id}|${res.permintaan.designation_name}`);
                    posisi_select.update();
                    $('#pengganti_hidden').val(res.permintaan.pengganti);
                }, 1200);
                get_posisi();
                if ((res.permintaan.dasar).trim() == "Penggantian Untuk") {
                    get_pengganti(res.permintaan.pengganti)
                } else {
                    console.log('disabled');
                    $('#pengganti').attr('disabled', true);
                    pengganti_select.update();
                }
            }, 1500);
        })
    }

    function show_add_permintaan() {
        $('#modal_add_permintaan').modal('show');
        $('#proses_permintaan').prop('disabled', false);
        // Reset the modal to add permintaan 
        department_select.clear();
        posisi_select.clear();
        location_select.clear();
        status_karyawan_select.clear();
        tipe_kontrak_select.clear();
        gender_select.clear();
        perencanaan_select.clear();
        permohonan_select.clear();
        pengalaman_select.clear();
        pengganti_select.clear();
        $('#form_add_permintaan').trigger('reset');
        $('#job_desc').summernote('code', '');
        $('#kpi').summernote('code', '');
        $('#form_add_permintaan textarea').text('');
        $('#status_approve').next('.nice-select').hide();
        $('#modal_add_permintaan .modal-title').text('Add Permintaan');
        // End Reset the modal to add permintaan
        $.ajax({
            url: "<?= base_url('recruitment/permintaan_karyawan/get_perusahaan') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let perusahaan = '<option selected disabled> --Pilih Perusahaan-- </option>';
                res.perusahaan.forEach((value, index) => {
                    if (value.last_name !== null && value.last_name !== '') {
                        perusahaan += `<option value = "${value.user_id} | ${value.company_id}"> ${value.first_name} ` + `${value.last_name} </option>`;
                    } else {
                        perusahaan += `<option value = "${value.user_id} | ${value.company_id}"> ${value.first_name} </option>`;
                    }
                })
                $('#perusahaan').html(perusahaan);
                perusahaan_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
        get_kel_posisi();
        get_status_karyawan();
        get_tipe_kontrak();
    }

    function show_di_modal(job_id) {

        console.log('job id = ' + job_id);
        get_candidates('', '', '', 'dt_di', job_id);

        $('#modal_daftar_interview').modal('show');
        // $.ajax({
        //     url: "<?= base_url() ?>/recruitment/permintaan_karyawan/detail_permintaan",
        //     type: "POST",
        //     data: {
        //         id: id
        //     },
        //     dataType: "JSON",
        //     success: function(res) {
        //         console.log(res);
        //         $('#detail_jabatan').text(res['permintaan'][0].job_title);
        //         $('#detail_jumlah').text(res['permintaan'][0].job_vacancy + ' Orang');
        //         $('#detail_perusahaan').text(res['permintaan'][0].company);
        //         $('#detail_dep').text(res['permintaan'][0].department);
        //         $('#detail_loc').text(res['permintaan'][0].location);
        //         $('#detail_kel').text(res['permintaan'][0].position);
        //         $('#detail_stat').html(res['permintaan'][0].job_type + ' (<i>' + res['permintaan'][0].type_contract + '</i>)');
        //         $('#detail_per').text(res['permintaan'][0].perencanaan);
        //         $('#detail_salary').text(res['permintaan'][0].salary);
        //         $('#detail_latar').text(res['permintaan'][0].latar_kebutuhan);
        //         $('#detail_kpi').text(res['permintaan'][0].kpi);
        //         $('#detail_finan').text(res['permintaan'][0].financial);
        //         $('#detail_jbl').text(res['permintaan'][0].bawahan_langsung + ' Orang');
        //         $('#detail_jbtl').text(res['permintaan'][0].bawahan_tidak + ' Orang');
        //         $('#detail_pen').text(res['permintaan'][0].pendidikan);
        //         $('#detail_skill').text(res['permintaan'][0].kemampuan);
        //         $('#detail_kompetensi').text(res['permintaan'][0].komp_kunci);
        //         $('#detail_kepemimpinan').text(res['permintaan'][0].komp_pemimpin);
        //         // Gender
        //         let gender = 'No Reference';
        //         if (res['permintaan'][0].gender == 0) {
        //             gender = 'Male';
        //         } else if (res['permintaan'][0].gender == 1) {
        //             gender = 'Female';
        //         }
        //         $('#detail_gender').text(gender);

        //         // Dasar Permohonan
        //         let permohonan = '';
        //         if (res['permintaan'][0].dasar == "Penggantian Untuk") {
        //             permohonan = res['permintaan'][0].dasar + ' ' + res['permintaan'][0].pengganti;
        //         } else {
        //             permohonan = res['permintaan'][0].dasar;
        //         }
        //         $('#detail_dasar').text(permohonan);
        //         // Latar Belakang Kebutuhan
        //         let desc = res['permintaan'][0].long_description;
        //         desc = decodeHtmlEntities(desc);
        //         new_desc = desc.replace(/<ol>/g, "<ul>").replace(/<\/ol>/g, "</ul>");
        //         $('#detail_desc').html(new_desc);
        //         // Pengalaman Kerja
        //         if (res['permintaan'][0].minimum_experience == 0) {
        //             $('#detail_kerja').text('Fresh');
        //         } else if (res['permintaan'][0].minimum_experience == 1) {
        //             $('#detail_kerja').text(res['permintaan'][0].minimum_experience + ' Year');
        //         } else {
        //             $('#detail_kerja').text(res['permintaan'][0].minimum_experience + ' Years');
        //         }
        //     }
        // })
    }

    // addnew
    function show_list_interview() {
        get_candidates_for_feedback('', '', '', 'dt_di', '');
        
        $('#modal_daftar_interview').modal('show');
    }

    function get_candidates_for_feedback(start, end, status, table, job_id) {
        $('#' + table).DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'List Job Candidates',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>recruitment/interview/get_candidates_for_feedback",
                "data": {
                    start: start,
                    end: end,
                    id: status,
                    job_id: job_id
                }
            },
            "columns": [{
                    'data': 'application_id',
                    'render': function(data, type, row) {

                        return `<a href="https://trusmiverse.com/apps/recruitment/interview/detail/${row['application_id']}" target="_blank">
                                <button type = "button" class = "btn btn-warning btn-sm m-b-0-0 waves-effect waves-light"> 
                                    <i class = "bi bi-pencil" style = "color:white;" ></i>
                                </button > </a>`;

                    }
                },
                {
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        if (row['category_name'] != null) {
                            position = `${row['job_title']}<br><span class = "text-muted fs-9">${row['category_name']}</span>`;
                        } else {
                            position = `${row['job_title']}`;
                        }
                        return position;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'full_name',
                },
                {
                    'data': 'contact',
                },
                {
                    'data': 'email',
                },
                {
                    'data': 'application_status',
                    'render': function(data, type, row) {
                        status = '';
                        if (data == 3) {
                            status = '<span class="badge bg-primary">' + row['status_hasil'] + '</span>';
                        } else if (data == 6) {
                            status = '<span class="badge bg-danger">' + row['status_hasil'] + '</span>';
                        } else if (data == 5) {
                            status = '<span class="badge bg-warning">' + row['status_hasil'] + '</span>';
                        }
                        return status
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'created_at',
                },
                {
                    'data': 'status_interview',
                    'render': function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-success">Approved</span>';
                        } else if (data == 0) {
                            return '<span class="badge bg-danger">Rejected</span>';
                        } else {
                            return ''
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'tgl_interview',
                },
                {
                    'data': 'jam_interview',
                },
                {
                    'data': 'lokasi_interview',
                },
                {
                    'data': 'alasan_interview',
                },
                {
                    'data': 'is_lolos',
                    'render': function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-success">Lolos</span>';
                        } else if (data == 0) {
                            return '<span class="badge bg-danger">Gagal</span>';
                        } else {
                            return ''
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'hasil_interview',
                }
            ],
        });
    }

    function get_department() {
        perusahaan = $('#perusahaan').val();
        if (perusahaan != null) {
            company = perusahaan.split('|');
            $.ajax({
                url: "<?= base_url('recruitment/permintaan_karyawan/get_department') ?>",
                method: "POST",
                data: {
                    id: company[1]
                },
                dataType: "JSON",
                success: function(res) {
                    console.log(res);
                    let department = '<option selected disabled> --Pilih Department-- </option>';
                    res.department.forEach((value, index) => {
                        department += `<option value = "${value.department_id}"> ${value.department_name}</option>`;
                    })
                    $('#department').html(department);
                    department_select.update();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function get_posisi() {
        perusahaan = $('#perusahaan').val();
        if (perusahaan != null) {
            company = perusahaan.split('|');
            id_department = $('#department').val();
            $.ajax({
                url: "<?= base_url('recruitment/permintaan_karyawan/get_posisi') ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id_perusahaan: company[1],
                    id_department: id_department
                },
                success: function(res) {
                    let posisi = '<option selected disabled> --Pilih Posisi-- </option><option value = "add_jabatan"> + Tambah Jabatan / Posisi Baru </option>';
                    res.posisi.forEach((value, index) => {
                        posisi += `<option value = "${value.designation_id}|${value.designation_name}"> ${value.designation_name}</option>`;
                    })
                    $('#posisi').html(posisi);
                    posisi_select.update();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })

        }
    }

    function get_location() {
        perusahaan = $('#perusahaan').val();
        if (perusahaan != null) {
            company = perusahaan.split('|');
            $.ajax({
                url: "<?= base_url('recruitment/permintaan_karyawan/get_location') ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id_perusahaan: company[1]
                },
                success: function(res) {
                    let location = '<option selected disabled> --Pilih Lokasi-- </option>';
                    res.location.forEach((value, index) => {
                        location += `<option value = "${value.location_id}"> ${value.location_name}</option>`;
                    })
                    $('#location').html(location);
                    location_select.update();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function get_kel_posisi() {
        $.ajax({
            url: "<?= base_url('recruitment/permintaan_karyawan/get_kel_posisi') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let posisi = '<option selected disabled> --Pilih Kelompok Posisi-- </option>';
                res.posisi.forEach((value, index) => {
                    posisi += `<option value = "${value.role_id}"> ${value.role_name}</option>`;
                })
                $('#kel_posisi').html(posisi);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function get_status_karyawan() {
        $.ajax({
            url: "<?= base_url('recruitment/permintaan_karyawan/get_status_karyawan') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let status = '<option selected disabled> --Pilih Status-- </option>';
                res.status_karyawan.forEach((value, index) => {
                    status += `<option value = "${value.job_type_id}"> ${value.type}</option>`;
                })
                $('#status_karyawan').html(status);
                status_karyawan_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function get_tipe_kontrak() {
        $.ajax({
            url: "<?= base_url('recruitment/permintaan_karyawan/get_tipe_kontrak') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                let kontrak = '<option selected disabled> --Pilih Tipe Kontrak-- </option>';
                res.tipe_kontrak.forEach((value, index) => {
                    kontrak += `<option value = "${value.contract_type_id}"> ${value.name}</option>`;
                })
                $('#tipe_kontrak').html(kontrak);
                tipe_kontrak_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function get_pengganti(nama) {
        perusahaan = $('#perusahaan').val();
        if ($('#permohonan').val() == 'Penggantian Untuk') {
            if (perusahaan == null) {
                swal("Perusahaan belum dipilih", "Harap pilih perusahaan", "info");
                return;
            } else if (perusahaan != null) {
                $('#pengganti').removeAttr('disabled');
                company = perusahaan.split('|');
                $.ajax({
                    url: "<?= base_url('recruitment/permintaan_karyawan/get_pengganti') ?>",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        id: company[1],
                        nama: nama
                    },
                    success: function(res) {
                        let pengganti = '<option disabled> --Pilih Pengganti-- </option>';
                        res.pengganti.forEach((value, index) => {
                            if (value.last_name !== '') {
                                if (value.selected == '1') {
                                    pengganti += `<option value = "${value.user_id}" selected> ${value.first_name} ` + `${value.last_name}</option>`;
                                } else {
                                    pengganti += `<option value = "${value.user_id}"> ${value.first_name} ` + `${value.last_name}</option>`;
                                }
                            } else {
                                if (value.selected == '1') {
                                    pengganti += `<option value = "${value.user_id}" selected> ${value.first_name} ` + `</option>`;
                                } else {
                                    pengganti += `<option value = "${value.user_id}"> ${value.first_name} ` + `</option>`;
                                }
                            }
                        })
                        $('#pengganti').html(pengganti);
                        pengganti_select.update();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                })
            } else {
                $('#pengganti').attr('disabled', true);
            }
        }
    }

    function send_pengganti() {
        $('#pengganti_hidden').val($('#pengganti option:selected').text());
    }

    function get_dt_posisi() {
        department = $('#department').val();
        posisi = $('#posisi').val();
        if (posisi != '--Pilih Jabatan / Posisi--' && posisi != null && department != null) {
            $.ajax({
                url: "<?= base_url('recruitment/permintaan_karyawan/get_dt_posisi') ?>",
                method: "POST",
                data: {
                    department: department,
                    posisi: posisi
                },
                dataType: "JSON",
                success: function(res) {
                    console.log(res);
                    (res['role_id'] !== null) ? $('#kel_posisi').val(res['role_id']): '';
                    kel_posisi_select.update();
                    $('#job_desc').summernote('code', res['job_desc']);
                    $('#kpi').summernote('code', res['job_kpi']);
                    $('#bawahan_lgsg').val(res['bawahan']);
                    $('#key_kompetensi').val(res['kompetensi']);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function add_permintaan() {
        // Check all input and select elements in the modal
        form = $('#form_add_permintaan');
        if (check_empty_field()) {
            return;
        } else {
            $.confirm({
                title: 'Save Form',
                content: 'Permintaan form will be saved',
                icon: 'fa fa-question',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Yes',
                        btnClass: 'btn-blue',
                        action: function() {
                            $.confirm({
                                icon: 'fa fa-spinner fa-spin',
                                title: 'Please Wait!',
                                theme: 'material',
                                type: 'blue',
                                content: 'Loading...',
                                buttons: {
                                    close: {
                                        isHidden: true,
                                        actions: function() {}
                                    },
                                },
                                onOpen: function() {
                                    $.ajax({
                                        url: "<?= base_url('recruitment/permintaan_karyawan/add_permintaan') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.insert == true) {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Success!',
                                                    buttons: {
                                                        close: function() {},
                                                    },
                                                });
                                                $('#proses_permintaan').prop('disabled', true)
                                                $('#modal_add_permintaan').modal('hide');
                                                $('#dt_pk').DataTable().ajax.reload();
                                                // success_alert('Permintaan akan segera diproses');
                                            }, 250);
                                        } else {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: 'Failed!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        }
                                    }).fail(function(jqXHR, textStatus) {
                                        // setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Failed!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                        // }, 250);
                                    });
                                },

                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        }
    }

    function get_data_pengganti(nama) {
        $.ajax({
            url: "<?= base_url('recruitment/permintaan_karyawan/get_data_pengganti') ?>",
            method: "POST",
            data: {
                nama: nama
            },
            dataType: "JSON",
            success: function(res) {
                $('#pengganti').val(res.pengganti.user_id);
                setTimeout(() => {
                    pengganti_select.update();
                }, 250);
            }
        })
    }

    function check_empty_field() {
        let isEmptyField = false;
        if ($('#perusahaan').val() == null || $('#perusahaan').val() == '') {
            error_alert("Perusahaan is required!");
            return true;
        }
        if ($('#department').val() == '' || $('#department').val() == null || $('#department').val() == '--Pilih Department--') {
            error_alert("Department is required!");
            return true;
        }
        if ($('#posisi').val() == '' || $('#posisi').val() == null || $('#posisi').val() == '--Pilih Jabatan / Posisi--') {
            error_alert("Posisi / Jabatan is required!");
            return true;
        }
        if ($('#jumlah').val() == '' || $('#jumlah').val() == null) {
            error_alert("Jumlah is required!");
            return true;
        } else {
            if ($('#perusahaan').val().substring(0, 1) == 3 && $('#jumlah').val() > 3) {
                error_alert("Jumlah Kebutuhan maksimal 3 per FPK!");
                return true;
            }
        }
        if ($('#location').val() == '' || $('#location').val() == null || $('#location').val() == '--Pilih Lokasi--') {
            console.log($('#location').val());
            error_alert("Location is required!");
            return true;
        }
        if ($('#kel_posisi').val() == '' || $('#kel_posisi').val() == null || $('#kel_posisi').val() == '--Pilih Kelompok Posisi--') {
            error_alert("Kelompok Posisi is required!");
            return true;
        }
        if ($('#status_karyawan').val() == '' || $('#status_karyawan').val() == null || $('#status_karyawan').val() == '--Pilih Status--') {
            error_alert("Status karyawan is required!");
            return true;
        }
        if ($('#tipe_kontrak').val() == '' || $('#tipe_kontrak').val() == null || $('#tipe_kontrak').val() == '--Pilih Tipe Kontrak--') {
            error_alert("Tipe kontrak is required!");
            return true;
        }
        if ($('#gender').val() == '' || $('#gender').val() == null || $('#gender').val() == '--Pilih Gender--') {
            error_alert("Gender is required!");
            return true;
        }
        if ($('#perencanaan').val() == '' || $('#perencanaan').val() == null || $('#perencanaan').val() == '--Pilih Perencanaan--') {
            error_alert("Perencanaan is required!");
            return true;
        }
        if ($('#permohonan').val() == '' || $('#permohonan').val() == null || $('#permohonan').val() == '--Pilih Dasar Permohonan--') {
            error_alert("Dasar Permohonan is required!");
            return true;
        }
        if ($('#pengganti').is(':enabled')) {
            if ($('#pengganti').val() == '' || $('#pengganti').val() == null || $('#pengganti').val() == '--Pilih Dasar Pengganti--') {
                error_alert("Pengganti is required!");
                return true;
            }
        }
        if ($('#salary').val() == '' || $('#salary').val() == null) {
            error_alert("Salary is required!");
            return true;
        }
        if ($('#latar_belakang').val() == '' || $('#latar_belakang').val() == null) {
            error_alert("Latar belakang is required!");
            return true;
        }
        if (($('#job_desc').summernote('code')).trim() == '' || $('#job_desc').summernote('code') == null) {
            error_alert("Job description is required!");
            return true;
        } else {
            job_desc = $('#job_desc').summernote('code').trim();
            arr_job_desc = job_desc.split(".").filter(function(item) {
                if (item != "&nbsp;") {
                    return item.trim().length > 0;
                }
            });
            if (arr_job_desc.length < 3) {
                error_alert("Job Description harus lebih dari 2 kalimat. (Gunakan titik di akhir kalimat)");
                return true;
            }
        }
        if (($('#kpi').summernote('code')).trim() == '' || $('#kpi').summernote('code') == null) {
            error_alert("KPI is required!");
            return true;
        } else {
            if ($('#kpi').val().length < 10) {
                console.log($('#kpi').val().length)
                error_alert("KPI minimal terdiri dari 10 kata.");
                return true;
            }
        }
        if ($('#bawahan_lgsg').val() == '' || $('#bawahan_lgsg').val() == null) {
            error_alert("Bawahan langsung is required!");
            return true;
        }
        if ($('#pendidikan').val() == '' || $('#pendidikan').val() == null) {
            error_alert("Pendidikan is required!");
            return true;
        }
        if ($('#financial').val() == '' || $('#financial').val() == null) {
            error_alert("Financial is required!");
            return true;
        }
        if ($('#bawahan_tidak_lgsg').val() == '' || $('#bawahan_tidak_lgsg').val() == null) {
            error_alert("Bawahan tidak langsung is required!");
            return true;
        }
        if ($('#pengalaman').val() == '' || $('#pengalaman').val() == null || $('#pengalaman').val() == '--Pilih Pengalaman Kerja--') {
            error_alert("Pengalaman is required!");
            return true;
        }
        if ($('#kemampuan').val() == '' || $('#kemampuan').val() == null) {
            error_alert("Kemampuan is required!");
            return true;
        }
        if ($('#key_kompetensi').val() == '' || $('#key_kompetensi').val() == null) {
            error_alert("Kunci kompetensi is required!");
            return true;
        }
        if ($('#leader_komp').val() == '' || $('#leader_komp').val() == null) {
            error_alert("Kompetensi kepemimpinan is required!");
            return true;
        }
        // ($('#status_approve').is(':visible') && $('#status_approve').val() == 1) ||
        if ($('#status_approve').is(':visible') && $('#status_approve').val() == '') {
            error_alert("Pilih status approve!");
            return true;
        }
        return false;
    }


    $('#posisi').on('change', function() {
        get_dt_posisi();
        if ($('#posisi').val() == 'add_jabatan') {
            perusahaan = $('#perusahaan').val();
            company = perusahaan.split('|');
            $('#modal_add_jabatan').modal('show');
            $('#perusahaan_job_profile').val($('#perusahaan option:selected').text());
            $('#department_job_profile').val($('#department option:selected').text());
            $('#hidden_perusahaan_job_profile').val(company[1]);
            $('#hidden_department_job_profile').val($('#department').val());

        }
    })

    function add_jabatan() {
        console.log($('#jabatan_job_profile').val());
        console.log($('#hidden_perusahaan_job_profile').val());
        console.log($('#hidden_department_job_profile').val());
        if ($('#jabatan_job_profile').val() == null || $('#jabatan_job_profile').val() == '') {
            error_alert('Jabatan / Posisi is required');
        } else {
            perusahaan = $('#hidden_perusahaan_job_profile').val();
            department = $('#hidden_department_job_profile').val();
            jabatan = $('#jabatan_job_profile').val();
            $.ajax({
                url: "<?= base_url('recruitment/permintaan_karyawan/add_jabatan') ?>",
                method: "POST",
                data: {
                    perusahaan: perusahaan,
                    department: department,
                    jabatan: jabatan
                },
                dataType: "JSON",
                success: function(res) {
                    swal('Berhasil mengajukan permintaan', 'Permintaan akan segera diproses', 'success')
                    // success_alert('Jabatan/Posisi baru berhasil diajukan.');
                    $('#modal_add_jabatan').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function edit_permintaan() {
        form = $('#form_add_permintaan');
        console.log(form.serialize())
        if (check_empty_field()) {
            return;
        } else {
            $.confirm({
                title: 'Save Form',
                content: 'Permintaan form will be saved',
                icon: 'fa fa-question',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Yes',
                        btnClass: 'btn-blue',
                        action: function() {
                            $.confirm({
                                icon: 'fa fa-spinner fa-spin',
                                title: 'Please Wait!',
                                theme: 'material',
                                type: 'blue',
                                content: 'Loading...',
                                buttons: {
                                    close: {
                                        isHidden: true,
                                        actions: function() {}
                                    },
                                },
                                onOpen: function() {
                                    $.ajax({
                                        url: "<?= base_url('recruitment/permintaan_karyawan/save_edit_permintaan') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.update_pk == true) {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Success!',
                                                    buttons: {
                                                        close: function() {},
                                                    },
                                                });
                                                $('#modal_add_permintaan').modal('hide');
                                                $('#dt_pk').DataTable().ajax.reload();
                                                // success_alert('Berhasil memperbaharui data permintaan.')
                                            }, 250);
                                        } else {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: response.message,
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        }
                                    }).fail(function(jqXHR, textStatus) {
                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Failed!' + textStatus,
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
                    cancel: function() {}
                }
            });
        }
    }
    $('#permohonan').on('change', function() {
        if ($('#permohonan').val() != 'Penggantian Untuk') {
            pengganti_select.disable();
            $('#pengganti_hidden').val('');
            $('#pengganti').prop('disabled', true);
        } else {
            pengganti_select.enable();
        }
    })
    $('#perusahaan').on('change', function() {
        if ($('#permohonan').val() == 'Penggantian Untuk') {
            get_pengganti(null);
        }
    })
    $('#proses_permintaan').on('click', function() {
        if ($('#status_approve').next('.nice-select').is(':visible')) {
            edit_permintaan()
        } else {
            add_permintaan()
        }
    })
    // Fungsi untuk mendekodekan entitas HTML
    function decodeHtmlEntities(str) {
        let textarea = document.createElement("textarea");
        textarea.innerHTML = str;
        return textarea.value;
    }
    // NiceSelect
    let perusahaan_select = NiceSelect.bind(document.getElementById('perusahaan'), {
        searchable: true,
        isAjax: false,
    });
    let department_select = NiceSelect.bind(document.getElementById('department'), {
        searchable: true,
        isAjax: false,
    });
    let posisi_select = NiceSelect.bind(document.getElementById('posisi'), {
        searchable: true,
        isAjax: false,
    });
    let location_select = NiceSelect.bind(document.getElementById('location'), {
        searchable: true,
        isAjax: false,
    });
    let kel_posisi_select = NiceSelect.bind(document.getElementById('kel_posisi'), {
        searchable: true,
        isAjax: false,
    });
    let status_karyawan_select = NiceSelect.bind(document.getElementById('status_karyawan'), {
        searchable: true,
        isAjax: false,
    });
    let tipe_kontrak_select = NiceSelect.bind(document.getElementById('tipe_kontrak'), {
        searchable: true,
        isAjax: false,
    });
    let gender_select = NiceSelect.bind(document.getElementById('gender'), {
        searchable: true,
        isAjax: false,
    });
    let perencanaan_select = NiceSelect.bind(document.getElementById('perencanaan'), {
        searchable: true,
        isAjax: false,
    });
    let permohonan_select = NiceSelect.bind(document.getElementById('permohonan'), {
        searchable: true,
        isAjax: false,
    });
    let pengganti_select = NiceSelect.bind(document.getElementById('pengganti'), {
        searchable: true,
        isAjax: false,
    });
    let pengalaman_select = NiceSelect.bind(document.getElementById('pengalaman'), {
        searchable: true,
        isAjax: false,
    });
    let status_approve_select = NiceSelect.bind(document.getElementById('status_approve'), {
        searchable: true,
        isAjax: false,
    });
    //End Nice Select 
    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 2000,
        });
    }
</script>