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

    var perusahaan_select = NiceSelect.bind(document.getElementById('perusahaan'), {
        searchable: true,
        isAjax: false,
    });

    var department_select = NiceSelect.bind(document.getElementById('department'), {
        searchable: true,
        isAjax: false,
    });

    var jabatan_select = NiceSelect.bind(document.getElementById('jabatan'), {
        searchable: true,
        isAjax: false,
    });

    var location_select = NiceSelect.bind(document.getElementById('location'), {
        searchable: true,
        isAjax: false,
    });

    var kel_posisi_select = NiceSelect.bind(document.getElementById('kel_posisi'), {
        searchable: true,
        isAjax: false,
    });

    var status_karyawan_select = NiceSelect.bind(document.getElementById('status_karyawan'), {
        searchable: true,
        isAjax: false,
    });

    var tipe_kontrak_select = NiceSelect.bind(document.getElementById('tipe_kontrak'), {
        searchable: true,
        isAjax: false,
    });

    var gender_select = NiceSelect.bind(document.getElementById('gender'), {
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
    let status_approval_select = NiceSelect.bind(document.getElementById('status_approval'), {
        searchable: true,
        isAjax: false,
    });
    let status_select = NiceSelect.bind(document.getElementById('status'), {
        searchable: true,
        isAjax: false,
    });
    let pic_recruiter_select = NiceSelect.bind(document.getElementById('pic_recruiter'), {
        searchable: true,
        isAjax: false,
    });
    let reason_select = NiceSelect.bind(document.getElementById('reason'), {
        searchable: true,
        isAjax: false,
    });
    let category_select = NiceSelect.bind(document.getElementById('category'), {
        searchable: true,
        isAjax: false,
    });



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

            $('input[name="startdate_permintaan"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate_permintaan"]').val(end.format('YYYY-MM-DD'));
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

        
    }); // document ready

    function filter_dt_job_post(){
        start = $('#start').val();
        end = $('#end').val();
        if(start == '' || end == ''){
            start = moment().startOf('month').format('YYYY-MM-DD');
            end = moment().endOf('month').format('YYYY-MM-DD');
            $('#start').val(start);
            $('#end').val(end);
        }
        dt_job_post(start, end);
    }

    function dt_job_post(start, end) {
        
        $('#dt_job_post').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            // "order": [
            //     [0, 'desc']
            // ],
            buttons: [{
                title: 'List Permintaan',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>recruitment/job_post/dt_job_post",
                "method": "POST",
                "dataType": 'json',
                "data": {
                    start: start,
                    end: end
                }
            },
            "columns": [
                {
                    'data': 'job_id',
                    'render': function(data, type, row) {
                        let button = `<a onclick="process_job(${data}, 'edit')" target="_blank" class="btn p-0"><i class="bi bi-pencil text-success" title="Edit Job?"></i></a>
                                      <a onclick="delete_job(${data})" target="_blank" class="btn p-0"><i class="bi bi-trash text-danger" title="Delete Job?"></i></a> 
                                      <a href="https://trusmiverse.com/apps/recruitment/job_candidates/get_candidates_by_job/${row['id_xin_job']}" target="_blank" class="btn p-0" title="Show Candidates"><i class="bi bi-person-vcard text-primary"></i></a>
                                      <a href="https://karir-backup.trusmigroup.com/home/detail/${row['job_url']}" target="_blank" class="btn p-0" title="Show Job"><i class="bi bi-eye text-info"></i></a>
                                      <a href="https://karir.trusmigroup.com/detail/${row['job_url']}" target="_blank" class="btn p-0" title="Show Job NEW"><i class="bi bi-eye text-warning"></i></a>
                                        `;
                        return button
                    }
                },
                {
                    'data': 'no_fpk',
                },
                {
                    'data': 'job_title',
                },
                {
                    'data': 'employer',
                },
                {
                    'data': 'location',
                },
                {
                    'data': 'company',
                },
                {
                    'data': 'posted_date',

                },
                {
                    'data': 'status',
                    'render': function(data, type, row, meta) {
                        let bgColor = 'bg-blue text-white';
                        if (row['id_status'] == 1) {
                            bgColor = 'bg-success text-white';
                        } else if (row['id_status'] == 2) {
                            bgColor = 'bg-yellow text-dark';
                        } else {
                            bgColor = '';
                        }
                        
                        return `<a role="button" class="badge . ${bgColor}" style="cursor:default;">${row['status']}</a>`;
                    }
                },
                {
                    'data': 'status_approval',
                    'render': function(data, type, row, meta) {
                        let bgColor = 'bg-blue text-white';
                        if (row['id_status_approval'] == 4) {
                            bgColor = 'bg-success text-white';
                        } else if (row['id_status_approval'] == 5) {
                            bgColor = 'bg-red text-white';
                        } else {
                            bgColor = '';
                        }
                        
                        return `<a role="button" class="badge . ${bgColor}" style="cursor:default;">${data}</a>`;
                    }
                },
                {
                    'data': 'closing_date',
                },
                {
                    'data': 'requester',
                },
            ],
            // "createdRow": function(row, data, index) {
            //     var info = $('#dt_pk').DataTable().page.info();
            //     var rowNumber = (info.page * info.length) + (index + 1);
            //     $('td:eq(0)', row).html(rowNumber);
            // }
        });
    }

    function delete_job(job_id){
        // confirm
        $.confirm({
            title: 'Delete Job Post',
            content: 'Are you sure you want to delete this job post?',
            icon: 'fa fa-question',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'delete': {
                    text: 'Delete',
                    btnClass: 'btn-red',
                    action: function() {
                        $.ajax({
                            url: '<?= base_url(); ?>recruitment/job_post/delete_job',
                            method: "POST",
                            data: {
                                job_id: job_id
                            },
                            success: function(res) {
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
                                dt_job_post();
                            },
                        });
                    }
                },
                cancel: function() {

                },
            }
        });
    }

    function show_list_permintaan(){
        $('#modal_list_permintaan').modal('show');
        filter_permintaan();
    }

    function filter_permintaan(){
        start = $('#start_permintaan').val();
        end = $('#end_permintaan').val();
        if(start != "" || end != ""){
            dt_list_permintaan(start, end);
        }
    }
    
    function dt_list_permintaan(start, end) {
        
        $('#dt_list_permintaan').DataTable({
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
                "url": "<?= base_url(); ?>recruitment/job_post/dt_list_permintaan",
                "method": "POST",
                "dataType": 'json',
                "data": {
                    start: start,
                    end: end
                },
            },
            "columns": [{
                    'data': 'job_id',
                    'render': function(data, type, row) {
                        let button = `<a onclick = detail_permintaan(${row['job_id']}) target="_blank" class="btn btn-sm btn-primary me-1"><i class="bi bi-eye"></i></a>
                                        <a onclick = process_job(${row['job_id']}) target="_blank" class="btn btn-sm btn-success"><i class="bi bi-arrow-right"></i></a>`;
                        // if (row['id_status'] == 1 && edit == true) {
                        // }
                        return button
                    }
                },
                {
                    'data': 'job_title',
                },
                {
                    'data': 'position',
                },
                {
                    'data': 'location',
                },
                {
                    'data': 'department',
                },
                {
                    'data': 'company',
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
    
    
    function detail_permintaan(job_id) {

        $('#modal_detail_permintaan').modal('show');

        $.ajax({
            url: "<?= base_url() ?>/recruitment/job_post/dt_list_permintaan",
            type: "POST",
            data: {
                job_id: job_id
            },
            dataType: "JSON",
            success: function(res) {
                // console.log(res);
                $('#detail_jabatan').text(res['data'][0].job_title);
                $('#detail_jumlah').text(res['data'][0].job_vacancy + ' Orang');
                $('#detail_perusahaan').text(res['data'][0].company);
                $('#detail_dep').text(res['data'][0].department);
                $('#detail_loc').text(res['data'][0].location);
                $('#detail_kel').text(res['data'][0].position);
                $('#detail_stat').html(res['data'][0].job_type + ' (<i>' + res['data'][0].type_contract + '</i>)');
                $('#detail_per').text(res['data'][0].perencanaan);
                $('#detail_salary').text(res['data'][0].salary);
                $('#detail_latar').text(res['data'][0].latar_kebutuhan);
                $('#detail_kpi').text(res['data'][0].kpi);
                $('#detail_finan').text(res['data'][0].financial);
                $('#detail_jbl').text(res['data'][0].bawahan_langsung + ' Orang');
                $('#detail_jbtl').text(res['data'][0].bawahan_tidak + ' Orang');
                $('#detail_pen').text(res['data'][0].pendidikan);
                $('#detail_skill').text(res['data'][0].kemampuan);
                $('#detail_kompetensi').text(res['data'][0].komp_kunci);
                $('#detail_kepemimpinan').text(res['data'][0].komp_pemimpin);
                // Gender
                let gender = 'No Reference';
                if (res['data'][0].gender == 0) {
                    gender = 'Male';
                } else if (res['data'][0].gender == 1) {
                    gender = 'Female';
                }
                $('#detail_gender').text(gender);

                // Dasar Permohonan
                let permohonan = '';
                if (res['data'][0].permohonan == "Penggantian Untuk") {
                    permohonan = res['data'][0].permohonan + ' ' + res['data'][0].pengganti;
                } else {
                    permohonan = res['data'][0].permohonan;
                }
                $('#detail_dasar').text(permohonan);
                // Latar Belakang Kebutuhan
                
                // new_desc = res['data'][0].long_description.replace(/<ol>/g, "<ul>").replace(/<\/ol>/g, "</ul>");
                // $('#detail_desc').text(res['data'][0].long_description);

                // Pengalaman Kerja
                if (res['data'][0].minimum_experience == 0) {
                    $('#detail_kerja').text('Fresh');
                } else if (res['data'][0].minimum_experience == 1) {
                    $('#detail_kerja').text(res['data'][0].minimum_experience + ' Year');
                } else {
                    $('#detail_kerja').text(res['data'][0].minimum_experience + ' Years');
                }

            }
        })
    }


    function process_job(job_id, edit=null) {

        // reset form form_job
        $('#form_job').trigger('reset');

        $('#category').val('');
        category_select.update();

        $('#status_approval').val('');
        status_approval_select.update();

        $('.status_publish').hide();
        $('#status').val('');
        status_select.update();

        $('.pic_recruiter').hide();
        $('#pic_recruiter').val('');
        pic_recruiter_select.update();

        $('.reason').hide();
        $('#reason').val('');
        reason_select.update();

        // console.info(`job_id : ${job_id}`);

        $('#modal_proses_permintaan').modal('show');
        $('#job_id').val(job_id);

        $.ajax({
            url: "<?= base_url() ?>/recruitment/job_post/dt_list_permintaan",
            type: "POST",
            data: {
                job_id: job_id
            },
            dataType: "JSON",
            success: function(res) {
                
                get_perusahaan(res['data'][0].id_perusahaan, res['data'][0].company_id);
                get_department(res['data'][0].company_id, res['data'][0].id_department);
                get_jabatan(res['data'][0].company_id, res['data'][0].id_department, res['data'][0].designation_id);

                $('#jumlah').val(res['data'][0].job_vacancy);

                get_location(res['data'][0].company_id, res['data'][0].location_id);
                get_kel_posisi(res['data'][0].id_role);
                get_status_karyawan(res['data'][0].job_type);
                get_tipe_kontrak(res['data'][0].type_contract);

                $('#gender').val(res['data'][0].gender);
                gender_select.update();

                $('#perencanaan').val(res['data'][0].perencanaan);
                perencanaan_select.update();
                
                $('#permohonan').val(res['data'][0].permohonan);
                permohonan_select.update();
                
                get_pengganti(res['data'][0].permohonan, res['data'][0].company_id, res['data'][0].pengganti);


                $('#salary').val(res['data'][0].salary);
                $('#latar_belakang').val(res['data'][0].latar_kebutuhan);

                let job_desc = res['data'][0].long_description;
                job_desc = decodeHtmlEntities(job_desc);
                $('#job_desc').summernote('code', job_desc);

                let kpi = res['data'][0].kpi;
                kpi = decodeHtmlEntities(kpi);
                $('#kpi').summernote('code', kpi);


                $('#financial').val(res['data'][0].financial);


                $('#bawahan_lgsg').val(res['data'][0].bawahan_langsung);
                $('#bawahan_tidak_lgsg').val(res['data'][0].bawahan_tidak);


                $('#pendidikan').val(res['data'][0].pendidikan);

                $('#pengalaman').val(res['data'][0].minimum_experience);
                pengalaman_select.update();


                $('#kemampuan').val(res['data'][0].kemampuan);
                $('#key_kompetensi').val(res['data'][0].komp_kunci);
                $('#leader_komp').val(res['data'][0].komp_pemimpin);



                if(edit == null){
                    $('#btn_save_job').show();
                    $('#btn_update_job').hide();
                    get_category();
                }else{
                    setTimeout(() => {
                        $('#btn_save_job').hide();
                        $('#btn_update_job').show();
                        // console.info(`category_id: ${res['data'][0].category_id}`)
                        get_category(res['data'][0].category_id);
                        // $('#category').val(res['data'][0].category_id);
                        // category_select.update();
                        $('#closing_date').val(res['data'][0].closing_date);

                        id_status = res['data'][0].id_status;
                        $('#status_approval').val(id_status);
                        status_approval_select.update();

                        if(id_status == '4'){
                            $('.status_publish').show();
                            $('#hidden_status_publish').val(res['data'][0].status_publish);
                            $('#status').val(res['data'][0].status_publish);
                            status_select.update();
                            
                            $('.pic_recruiter').show();
                            $('#hidden_pic_recruiter').val(res['data'][0].pic_recruiter);
                            get_pic_recruiter(res['data'][0].pic_recruiter);

                        }else if(id_status == '5'){
                            $('.reason').show();
                            $('#hidden_reason').val(res['data'][0].alasan_reject);
                            $('#reason').val(res['data'][0].alasan_reject);
                            reason_select.update();
                        }

                    }, 100);
                }
                if(res['data'][0].question != null){
                    var id_question = res['data'][0].question.split(','); // jadi array: ["1", "2"]
                    $('.checkbox-question').each(function() {
                        var val = $(this).val();
                        if (id_question.includes(val)) {
                            $(this).prop('checked', true);
                        }
                    });
                }




            }
        })
    }

    function select_status_approval(){
        
        approval = $('#status_approval').val();
        
        if(approval == 4){ // 4 : Approved
            $('.reason').hide();
            $('.status_publish').show();
            $('.pic_recruiter').show();

            hidden_status_publish = $('#hidden_status_publish').val();
            hidden_pic_recruiter = $('#hidden_pic_recruiter').val();

            if(hidden_status_publish != '' || hidden_status_publish != null){
                $('#status').val(hidden_status_publish);
                status_select.update();

                console.info(`hidden_pic_recruiter : ${hidden_pic_recruiter}`);

                get_pic_recruiter(hidden_pic_recruiter);

            }else{

                $('#status').val('');
                status_select.update();

                $('#pic_recruiter').val('');
                pic_recruiter_select.update();
            }

        }else{ // 5 : Rejected
            $('.reason').show();
            $('.status_publish').hide();
            $('.pic_recruiter').hide();

            hidden_reason = $('#hidden_reason').val();
            if(hidden_reason != '' || hidden_reason != null){
                $('#reason').val(hidden_reason);
                reason_select.update();
            }else{
                $('#reason').val('');
                reason_select.update();
            }
        }

        

        if(hidden_status_publish != '' || hidden_status_publish != null){
            $('#status').val(hidden_status_publish);
            status_select.update();

            get_pic_recruiter(hidden_pic_recruiter);
        }else{   
            $('#reason').val('');
            reason_select.update();

            $('#status').val('');
            status_select.update();

            $('#pic_recruiter').val('');
            pic_recruiter_select.update();
        }

    }

    function get_pic_recruiter(pic=null) {

        $.ajax({
            url: "<?= base_url('recruitment/job_post/get_pic_recruiter') ?>",
            method: "GET",
            dataType: "JSON",
            success: function(res) {
                console.info(res)
                let pic_recruiter = `<option value="">-- Pilih PIC --</option>`;
                res.forEach((value, index) => {
                    pic_recruiter += `<option value="${value.user_id}" data-contact="${value.contact}"> ${value.karyawan} </option>`;
                })
                $('#pic_recruiter').html(pic_recruiter);
                if(pic != null || pic != ''){
                    $('#pic_recruiter').val(pic);
                }else{
                    $('#pic_recruiter').val('');
                }
            },
            complete: function() {
                pic_recruiter_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function select_pic_recruiter(inputElement){
        contact = $(inputElement).find(':selected').data('contact');
        $('#pic_recruiter_contact').val(contact);
        console.info(contact);
    }

    function get_perusahaan(id_perusahaan=null, company_id=null) {

        $.ajax({
            url: "<?= base_url('recruitment/job_post/get_perusahaan') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {

                let perusahaan = ``;
                res.perusahaan.forEach((value, index) => {

                    if (value.last_name !== null && value.last_name !== '') {
                        perusahaan += `<option value = "${value.user_id}|${value.company_id}"> ${value.first_name} ` + `${value.last_name} </option>`;
                    } else {
                        perusahaan += `<option value = "${value.user_id}|${value.company_id}"> ${value.first_name} </option>`;
                    }
                })
                $('#perusahaan').html(perusahaan);
                if(id_perusahaan != null){
                    $('#perusahaan').val(`${id_perusahaan}|${company_id}`);
                }else{
                    $('#perusahaan').val('');
                }
            },
            complete: function() {
                perusahaan_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function get_department(id_perusahaan=null, id_department=null) {
        
        if (id_perusahaan != null) {
            $.ajax({
                url: "<?= base_url('recruitment/job_post/get_department') ?>",
                method: "POST",
                data: {
                    id: id_perusahaan
                },
                dataType: "JSON",
                success: function(res) {
                    // console.log(res);
                    let department = ``;
                    res.department.forEach((value, index) => {
                        department += `<option value = "${value.department_id}"> ${value.department_name}</option>`;
                    })
                    $('#department').html(department);
                    if(id_department != null){
                        $('#department').val(id_department);
                    }else{
                        $('#department').val('');
                    }
                },
                complete: function(){
                    department_select.update();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function get_jabatan(company_id=null, department_id=null, designation_id=null) {

        console.info(`designation_id : ${designation_id}`);

        if (company_id != null) {
            $.ajax({
                url: "<?= base_url('recruitment/job_post/get_jabatan') ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id_perusahaan: company_id,
                    id_department: department_id
                },
                success: function(res) {
                    // let posisi = '<option disabled value=""> --Pilih Posisi-- </option><option value = "add_jabatan"> + Tambah Jabatan / Posisi Baru </option>';
                    let posisi = '<option disabled value=""> --Pilih Posisi-- </option>';
                    res.posisi.forEach((value, index) => {
                        posisi += `<option value = "${value.designation_id}"> ${value.designation_name}</option>`;
                        if(value.designation_id == designation_id){
                            $('#job_title').val(value.designation_name);
                        }
                    })
                    $('#jabatan').html(posisi);
                    if(designation_id != null){
                        $('#jabatan').val(designation_id);
                    }else{
                        $('#jabatan').val('');
                    }
                },
                complete: function(){
                    jabatan_select.update();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })

        }
    }

    function pilih_jabatan(){
        let id_jabatan = $('#jabatan :selected').val();
        let jabatan = $('#jabatan :selected').text();
        console.info(`id_jabatan : ${id_jabatan} | jabatan : ${jabatan}`);
        if(id_jabatan.trim() != 'add_jabatan'){
            $('#job_title').val(jabatan);
        }else{
            $('#job_title').val('');
        }

        jabatan_select.update();
        
    }

    function get_location(company_id=null, location_id=null) {
        console.info(`company_id : ${company_id} | location_id : ${location_id}`);
        if (company_id != null) {
            $.ajax({
                url: "<?= base_url('recruitment/job_post/get_location') ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id_perusahaan: company_id
                },
                success: function(res) {
                    let location = '<option selected disabled> --Pilih Lokasi-- </option>';
                    res.location.forEach((value, index) => {
                        location += `<option value = "${value.location_id}"> ${value.location_name}</option>`;
                    })
                    $('#location').html(location);
                    if(location_id != null){
                        $('#location').val(location_id);
                    }else{
                        $('#location').val('');
                    }
                },
                complete: function(){
                    location_select.update();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function get_kel_posisi(role_id=null) {
        console.info(role_id);
        $.ajax({
            url: "<?= base_url('recruitment/job_post/get_kel_posisi') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let posisi = '<option selected disabled> --Pilih Kelompok Posisi-- </option>';
                res.posisi.forEach((value, index) => {
                    posisi += `<option value = "${value.role_id}"> ${value.role_name}</option>`;
                })
                $('#kel_posisi').html(posisi);
                if(role_id != null){
                    $('#kel_posisi').val(role_id);
                }else{
                    $('#kel_posisi').val('');
                }
            },
            complete: function(){
                kel_posisi_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function get_status_karyawan(job_type=null) {
        console.info(`job_type : ${job_type}`);   
        $.ajax({
            url: "<?= base_url('recruitment/job_post/get_status_karyawan') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let status = '<option selected disabled> --Pilih Status-- </option>';
                res.status_karyawan.forEach((value, index) => {
                    status += `<option value = "${value.job_type_id}"> ${value.type}</option>`;
                })
                $('#status_karyawan').html(status);
                if(job_type != null){
                    $('#status_karyawan').val(job_type);
                }else{
                    $('#status_karyawan').val('');
                }
            },
            complete: function(){
                status_karyawan_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function get_tipe_kontrak(type_contract=null) {
        $.ajax({
            url: "<?= base_url('recruitment/job_post/get_tipe_kontrak') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let kontrak = '<option selected disabled> --Pilih Tipe Kontrak-- </option>';
                res.tipe_kontrak.forEach((value, index) => {
                    kontrak += `<option value = "${value.contract_type_id}"> ${value.name}</option>`;
                })
                $('#tipe_kontrak').html(kontrak);
                if(type_contract != null){
                   $('#tipe_kontrak').val(type_contract);
                }else{
                    $('#tipe_kontrak').val('');
                }
            },
            complete: function(){
                tipe_kontrak_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function get_pengganti(permohonan=null, company_id=null, pengganti=null) {
        // perusahaan = $('#perusahaan').val();
        if (permohonan == 'Penggantian Untuk') {
            if (perusahaan == null) {
                swal("Perusahaan belum dipilih", "Harap pilih perusahaan", "info");
                return;
            } else if (perusahaan != null) {
                $('#pengganti').removeAttr('disabled');
                // company = perusahaan.split('|');
                $.ajax({
                    url: "<?= base_url('recruitment/job_post/get_pengganti') ?>",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        id: company_id
                    },
                    success: function(res) {
                        let pengganti = '<option selected disabled> --Pilih Pengganti-- </option>';
                        res.pengganti.forEach((value, index) => {
                            if (value.last_name !== '') {
                                pengganti += `<option value = "${value.user_id}"> ${value.first_name} ` + `${value.last_name}</option>`;
                            } else {
                                pengganti += `<option value = "${value.user_id}"> ${value.first_name}</option>`;
                            }
                        })
                        $('#pengganti').html(pengganti);
                        if (pengganti != null) {
                            $('#pengganti').val(pengganti);
                        }else{
                            $('#pengganti').val('');
                        }
                    },
                    complete: function() {
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

    function get_category(category_id=null) {
        $.ajax({
            url: "<?= base_url('recruitment/job_post/get_category') ?>",
            method: "GET",
            dataType: "JSON",
            success: function(res) {
                let kontrak = '<option selected disabled> -- Select Category -- </option>';
                res.forEach((value, index) => {
                    kontrak += `<option value = "${value.category_id}"> ${value.category_name}</option>`;
                })
                $('#category').html(kontrak);
                if(category_id != null || category_id != '0'){
                   $('#category').val(category_id);
                }else{
                    $('#category').val('');
                }
            },
            complete: function(){
                category_select.update();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    }


    function save_job_post(edit=null){

        form = $('#form_job');

        // append edit to form
        if(edit != null){
            form.append(`<input type="hidden" name="edit" value="${edit}">`);
        }

        // print each value from form without serialize
        form_serialize = form.serialize();
        // convert serialize to json
        form_json = JSON.parse('{"' + form_serialize.replace(/&/g, '","').replace(/=/g, '":"') + '"}', function(key, value) {
            return key === "" ? value : decodeURIComponent(value)
        });
        console.log(form_json);

        if (check_empty_field()) {
            return;
        } else {

            $.confirm({
                title: 'Save Job Post',
                content: 'Job post form will be saved',
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
                                        url: "<?= base_url('recruitment/job_post/save_job_post') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.save_job_post == true) {
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
                                                
                                                $('#modal_proses_permintaan').modal('hide');
                                                filter_dt_job_post();
                                                filter_permintaan();
                                                
                                            }, 250);
                                        } else {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: response.reason,
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
        if ($('#jabatan').val() == '' || $('#jabatan').val() == null || $('#jabatan').val() == '--Pilih Jabatan / Posisi--') {
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
        // if ($('#status_approve').is(':visible') && $('#status_approve').val() == '') {
        //     error_alert("Pilih status approve!");
        //     return true;
        // }

        if ($('#category').val() == '' || $('#category').val() == null ) {
            $('#category').focus();
            error_alert("category is required!");
            return true;
        }

        if ($('#closing_date').val() == '' || $('#closing_date').val() == null ) {
            error_alert("Date of closing is required!");
            return true;
        }

        if ($('#status_approval').val() == '' ) {
            error_alert("Status Approval is required!");
            return true;
        }

        if ($('#status_approval').val() == 4 && $('#status').val() == '' ) {
            error_alert("Status Publish is required!");
            return true;
        }
        
        if ($('#status_approval').val() == 4 && $('#pic_recruiter').val() == '' ) {
            error_alert("PIC Recruiter is required!");
            return true;
        }
        
        if ($('#status_approval').val() == 5 && $('#reason').val() == '' ) {
            error_alert("Reason is required!");
            return true;
        }

        if ($('#pengganti').is(':enabled')) {
            if ($('#pengganti').val() == '' || $('#pengganti').val() == null || $('#pengganti').val() == '--Pilih Dasar Pengganti--') {
                error_alert("Pengganti is required!");
                return true;
            }
        }
        return false;
    }



    // OLD

    $('#status_permintaan').on('change', function() {
        start = $('input[name="startdate"]').val();
        end = $('input[name="enddate"]').val();
        get_permintaan(start, end);
    });


    function show_edit_modal(id) {
        $('#modal_add_permintaan .modal-title').text('Edit Permintaan');
        $('#status_approve').removeAttr('hidden');
        $('#proses_permintaan').prop('disabled', false);
        $.ajax({
            url: "<?= base_url() ?>/recruitment/job_post/edit_permintaan",
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
                    jabatan_select.update();
                    $('#pengganti_hidden').val(res.permintaan.pengganti);
                    if (res.permintaan.dasar == 'Penggantian Untuk') {
                        get_data_pengganti(res.permintaan.pengganti);
                    }
                }, 1200)
                get_posisi();
                (res.permintaan.dasar == "Penggantian Untuk") ? get_pengganti(): $('#pengganti').attr('disabled', true);
            }, 1500);
        })
    }

    function show_add_permintaan() {
        $('#modal_add_permintaan').modal('show');
        $('#proses_permintaan').prop('disabled', false);
        // Reset the modal to add permintaan 
        department_select.clear();
        jabatan_select.clear();
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
            url: "<?= base_url('recruitment/job_post/get_perusahaan') ?>",
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

    function send_pengganti() {
        $('#pengganti_hidden').val($('#pengganti option:selected').text());
    }

    function get_dt_posisi() {
        department = $('#department').val();
        posisi = $('#posisi').val();
        if (posisi != '--Pilih Jabatan / Posisi--' && posisi != null && department != null) {
            $.ajax({
                url: "<?= base_url('recruitment/job_post/get_dt_posisi') ?>",
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
                                        url: "<?= base_url('recruitment/job_post/add_permintaan') ?>",
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
            url: "<?= base_url('recruitment/job_post/get_data_pengganti') ?>",
            method: "POST",
            data: {
                nama: nama
            },
            dataType: "JSON",
            success: function(res) {
                $('#pengganti').val(res.pengganti.user_id);
                pengganti_select.update();
            }
        })
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
                url: "<?= base_url('recruitment/job_post/add_jabatan') ?>",
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
                                        url: "<?= base_url('recruitment/job_post/save_edit_permintaan') ?>",
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
            get_pengganti();
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
    
    
    // let status_approve_select = NiceSelect.bind(document.getElementById('status_approve'), {
    //     searchable: true,
    //     isAjax: false,
    // });
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