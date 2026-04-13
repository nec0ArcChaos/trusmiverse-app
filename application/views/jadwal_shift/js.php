<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- Jquery Confirm -->
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>
<!-- Exif -->
<script src="https://cdn.jsdelivr.net/npm/exif-js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>





<!-- ===================================== -->
 <script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>


<script type="text/javascript">
  
  $(document).ready(function() {


    



    $("#periode").datepicker({
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true,
    });

    slc_company = new SlimSelect({
        select: '#company',
    });

    slc_department = new SlimSelect({
        select: '#department',
    });

    // slc_employee = new SlimSelect({
    //     select: '#employee',
    // });

    // addnew
    slc_cutoff = new SlimSelect({
        select: '#cutoff',
    });

    $('#company').change(function() {
        company_id = $(this).val();

        $.ajax({
            url: '<?php echo base_url(); ?>hr/rekap_absen/get_department',
            type: 'POST',
            dataType: 'json',
            data: {
                company_id: company_id
            },
            success: function(response) {
                slc_department.setData(response);
                // slc_employee.setData([{
                //     text: 'All Employees',
                //     value: '0'
                // }])
            }
        });
    });

    $('#department').change(function() {
        company_id = $('#company').val();
        department_id = $(this).val();

        $.ajax({
            url: '<?php echo base_url(); ?>hr/rekap_absen/get_employees',
            type: 'POST',
            dataType: 'json',
            data: {
                company_id: company_id,
                department_id: department_id
            },
            success: function(response) {
                // slc_employee.setData(response);
            }
        });
    });

    $('#btn_filter').click(function() {
        // rekap_data();
        list_jadwal_shift();
    });


    let slimGrupShift = null;
    let slimShiftName = null;

  });


    function show_jam_shift(){

        $('#modal_jam_shift').modal('show');

        let table = $('#table_jam_shift').DataTable({

            destroy:true,
            processing:true,
            searching:true,
            paging:true,
            info:true,
            lengthChange: true,
            scrollX: true,
            responsive: true,
            dom:'Bfrtip',

            buttons:[
                {
                    extend:'excelHtml5',
                    title:'Data Jam Shift',
                    text:'Export Excel'
                }
            ],

            ajax:{
                url:"<?= base_url('jadwal_shift/cek_jam_shift') ?>",
                type:"GET",
                dataSrc:'data'
            },

            columns:[

                {data:'nama_grup'},
                // {data:'shift_name'},
                {
                    data: 'shift_name', // Sesuaikan dengan nama field Anda
                    render: function(data, type, row) {
                        // Cek apakah datanya ada (tidak null/kosong)
                        if (data) {
                            // Pecah berdasarkan koma, lalu gabungkan dengan tag <br>
                            return data.split(',').join('<br>');
                            
                            // Opsional: Jika Anda ingin menambahkan spasi atau list peluru (bullet),
                            // return '<ul><li>' + data.split(',').join('</li><li>') + '</li></ul>';
                        }
                        return data;
                    }
                },
                // {data:'designation_list'},
                {
                    data: 'designation_list', // Sesuaikan dengan nama field Anda
                    render: function(data, type, row) {
                        // Cek apakah datanya ada (tidak null/kosong)
                        if (data) {
                            // Pecah berdasarkan koma, lalu gabungkan dengan tag <br>
                            return data.split(',').join('<br>');
                            
                            // Opsional: Jika Anda ingin menambahkan spasi atau list peluru (bullet),
                            // return '<ul><li>' + data.split(',').join('</li><li>') + '</li></ul>';
                        }
                        return data;
                    }
                },

                {
                    data:null,
                    render:function(row){
                        return row.monday_in_time + ' - ' + row.monday_out_time;
                    }
                },
                {
                    data:null,
                    render:function(row){
                        return row.tuesday_in_time + ' - ' + row.tuesday_out_time;
                    }
                },
                {
                    data:null,
                    render:function(row){
                        return row.wednesday_in_time + ' - ' + row.wednesday_out_time;
                    }
                },
                {
                    data:null,
                    render:function(row){
                        return row.thursday_in_time + ' - ' + row.thursday_out_time;
                    }
                },
                {
                    data:null,
                    render:function(row){
                        return row.friday_in_time + ' - ' + row.friday_out_time;
                    }
                },
                {
                    data:null,
                    render:function(row){
                        return row.saturday_in_time + ' - ' + row.saturday_out_time;
                    }
                },
                {
                    data:null,
                    render:function(row){
                        return row.sunday_in_time + ' - ' + row.sunday_out_time;
                    }
                }

            ],

            initComplete:function(){

                let api = this.api();

                let grupColumn = api.column(0);
                let shiftColumn = api.column(1);

                let selectGrup = $('#filter_grup_shift');
                let selectShift = $('#filter_shift_name');

                selectGrup.html('<option value="">Semua Grup</option>');
                selectShift.html('<option value="">Semua Shift</option>');

                grupColumn.data().unique().sort().each(function(d){
                    if(d){
                        selectGrup.append(`<option value="${d}">${d}</option>`);
                    }
                });

                shiftColumn.data().unique().sort().each(function(d){
                    if(d){
                        selectShift.append(`<option value="${d}">${d}</option>`);
                    }
                });

                // aktifkan searchable select
                    $('#filter_grup_shift').each(function(){
                        if(!this.slim){
                            new SlimSelect({
                                select: this,
                                placeholder: 'Cari Grup Shift'
                            });
                        }
                    });

                    $('#filter_shift_name').each(function(){
                        if(!this.slim){
                            new SlimSelect({
                                select: this,
                                placeholder: 'Cari Shift'
                            });
                        }
                    });


            }

        });

        /*
        ======================
        FILTER GRUP
        ======================
        */

        $('#filter_grup_shift').off('change').on('change',function(){

            let val = $.fn.dataTable.util.escapeRegex(this.value);

            if(val === ''){
                table.column(0).search('').draw();
            }else{
                table.column(0).search('^'+val+'$', true, false).draw();
            }

        });

        /*
        ======================
        FILTER SHIFT
        ======================
        */

        $('#filter_shift_name').off('change').on('change',function(){

            let val = this.value;

            if(val === ''){
                table.column(1).search('').draw();
            }else{
                table.column(1).search('^'+val+'$', true, false).draw();
            }

        });


    }

    // $(document).on('shown.bs.modal', '#modal_jam_shift', function () {
    //     $('.ss-search input').focus();
    // });

    function list_jadwal_shift(){

        let department = $('#department').val();
        let periode    = $('#periode').val();
        let cutoff    = $('#cutoff').val();

        let table  = $('#dt_jadwal_shift').DataTable({

            lengthChange:false,
            searching:true,
            info:true,
            paging:true,
            autoWidth:false,
            destroy:true,

            dom:'Bfrtip',

            buttons:[
                {
                    extend:'excelHtml5',
                    title:'Data Jadwal Shift',
                    text:'<i class="bi bi-download text-white"></i>',
                    footer:true
                }
            ],

            ajax:{
                url:"<?= base_url('jadwal_shift/list_jadwal_shift') ?>",
                dataType:'JSON',
                type:"POST",
                data:{
                    department:department,
                    periode:periode,
                    cutoff:cutoff

                }
            },

            columns:[

                {data:'company_name'},
                {data:'department_name'},
                {data:'designation_name'},
                {data:'full_name'},
                {data:'tanggal'},
                {data:'day_name'},
                //   {data:'shift_name'},
                    {
                        data:'shift_name',
                        render:function(data,type,row){

                        //     return `<button class="btn btn-sm btn-outline-primary btn_edit_shift"
                        //                 data-id="${row.id}"
                        //                 data-office_shift_id="${row.office_shift_id}"
                        //                 data-shift_name="${row.shift_name}"

                        //                 data-tanggal="${row.tanggal}">
                        //                  ${row.shift_name}
                        //             </button>`;
                                if(type === 'display'){
                                    return `<button class="btn btn-sm btn-outline-primary btn_edit_shift"
                                                data-id="${row.id}"
                                                data-office_shift_id="${row.office_shift_id}"
                                                data-shift_name="${row.shift_name}"
                                                data-designation_id="${row.designation_id}"
                                                data-tanggal="${row.tanggal}">
                                                ${row.shift_name}
                                            </button>`;
                                }

                                return data; // untuk filter dan sorting

                        }
                        
                    },
                    {data:'cutoff',
                        render:function(data,type,row){  
                            if(data == 1){
                                return '21 - 20';
                            } else if(data == 2){
                                return '16-15';
                            } else {                                         
                                return '<?= date("01") ?>-<?= date("t") ?>';
                            }
                        }
                    },
                    {
                        data:'shift_name',
                        render:function(data,type,row){                                                      
                            return row.shift_in + ' - ' + row.shift_out; // untuk filter dan sorting
                        }
                        
                    },
                {data:'created_at'},
                {data:'input_by'}

            ],

            buttons:[
                {
                    extend:'excelHtml5',
                    title:'Data Jadwal Shift'
                }
            ],

            initComplete:function(){

                let api = this.api();

                let fullnameColumn = api.column(3);
                let hariColumn     = api.column(5); // kolom hari
                let shiftColumn    = api.column(6);

                let selectFullname = $('#filter_fullname');
                let selectHari     = $('#filter_hari');
                let selectShift    = $('#filter_shift');

                selectFullname.html('<option value="">Full Name</option>');
                selectShift.html('<option value="">All Shift</option>');
                selectHari.html('<option value="">Hari</option>');

                /*
                =========================
                FILTER FULLNAME
                =========================
                */

                fullnameColumn.data().unique().sort().each(function(d){
                    if(d){
                        selectFullname.append(`<option value="${d}">${d}</option>`);
                    }
                });

                /*
                =========================
                FILTER SHIFT
                =========================
                */

                shiftColumn.data().unique().sort().each(function(d){
                    if(d){
                        selectShift.append(`<option value="${d}">${d}</option>`);
                    }
                });

                /*
                ========================
                HARI
                ========================
                */
                hariColumn.data().unique().sort().each(function(d){
                    if(d){
                        selectHari.append(`<option value="${d}">${d}</option>`);
                    }
                });

            }

        });

            /*
            =========================
            EVENT FILTER FULLNAME
            =========================
            */

            $('#filter_fullname').off('change').on('change', function(){

                let val = this.value;

                if(val === ''){
                    table.column(3).search('').draw(); // reset filter
                }else{
                    table.column(3).search('^'+val+'$', true, false).draw();
                }

            });

            /*
            ========================
            FILTER HARI
            ========================
            */
            $('#filter_hari').off('change').on('change',function(){
                table.column(5).search(this.value).draw();
            });

            /*
            =========================
            EVENT FILTER SHIFT
            =========================
            */

            $('#filter_shift').off('change').on('change', function(){

                let val_shift = this.value;

                if(val_shift === ''){
                    table.column(6).search('').draw(); // reset filter
                }else{
                    table.column(6).search('^'+val_shift+'$', true, false).draw();
                }

            });

    }

    $(document).on('click','.btn_edit_shift',function(){

        let id_jadwal = $(this).data('id');
        let office_shift_id  = $(this).data('office_shift_id');
        let shift_name  = $(this).data('shift_name');
        let tanggal   = $(this).data('tanggal');
        let designation_id   = $(this).data('designation_id');

        let today  = new Date();
        let tglRow = new Date(tanggal);

         // batas minimal edit = hari ini + 2 hari
        let limitDate = new Date();
        limitDate.setDate(limitDate.getDate() - 2);

        let diffTime = tglRow - today;
        let diffDays = Math.ceil(diffTime / (1000*60*60*24));

        if(diffDays < 2){
            // swal("Peringatan","Shift tidak bisa diedit jika kurang dari 2 hari","warning");

            let maxEditDate = limitDate.toISOString().split('T')[0];
            swal(
            "Peringatan",
            "Shift tidak bisa diedit.\nTanggal yang bisa diedit minimal 2 hari sebelum current date: "+maxEditDate,
            "warning"
        );
            return;
        }

        $('#edit_id_jadwal').val(id_jadwal);
        $('#edit_tanggal').val(tanggal);
        $('#edit_shift_before').val(shift_name);

        load_shift_option(office_shift_id, designation_id);

        $('#modal_edit_shift').modal('show');

    });

    function load_shift_option(selected_shift, designation_id){

        $.ajax({
            url:"<?= base_url('jadwal_shift/get_shift') ?>",
            type:"POST",
            data:{
                designation_id:designation_id,
            },
            dataType:"JSON",

            success:function(res){

                let html = '';

                res.forEach(function(s){

                    let selected = (s.office_shift_id == selected_shift) ? 'selected' : '';

                    html += `<option value="${s.office_shift_id}" ${selected}>
                                ${s.shift_name}
                            </option>`;
                });

                $('#edit_shift').html(html);

            }

        });

    }

    function update_shift(){

        let id_jadwal = $('#edit_id_jadwal').val();
        let shift_id  = $('#edit_shift').val();

        $.ajax({

            url:"<?= base_url('jadwal_shift/update_shift') ?>",
            type:"POST",
            data:{
                id_jadwal:id_jadwal,
                shift_id:shift_id
            },

            success:function(res){

                let data = JSON.parse(res);

                if(data.status){

                    swal("Berhasil","Shift berhasil diupdate","success");

                    $('#modal_edit_shift').modal('hide');

                    list_jadwal_shift();

                }else{

                    swal("Gagal","Update shift gagal","error");

                }

            }

        });

    }

    function call_download_template(){
        console.log('klik download'); // cek dulu
            company_id = $('#company').val();
            department_id = $('#department').val();
            // employee_id = $('#employee').val();
            periode = $('#periode').val();
            cutoff = $('#cutoff').val(); // a

            if(company_id == 0 ){        
                swal("Peringatan","Company field harus dipilih terlebih dahulu!","warning");
                return false;
            } else if(department_id == 0 ){        
                swal("Peringatan","Department field harus dipilih terlebih dahulu!","warning");
                return false;
            } else if(periode == ''){        
                swal("Peringatan","Periode field harus dipilih terlebih dahulu!","warning");
                return false;
            } else if(cutoff == ''){        
                swal("Peringatan","Cutoff field harus dipilih terlebih dahulu!","warning");
                return false;
            }


            // redirect ke controller untuk download excel
            window.location.href = "<?= base_url('jadwal_shift/export_excel') ?>?company_id="
            + company_id
            + "&department_id=" + department_id
            + "&periode=" + periode
            + "&cutoff=" + cutoff;
    }

    function call_upload_template(){

        $('#file_jadwal').click();

    }

    $('#file_jadwal').change(function(){

        var file = $('#file_jadwal')[0].files[0];

        if(file == undefined){
            swal("Peringatan","Silahkan pilih file excel","warning");
            return false;
        }

        console.log(file);

        var formData = new FormData();
        formData.append('file', file);

        $.ajax({
            url: "<?= site_url('jadwal_shift/upload_excel') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache:false,

            success:function(res){
                //   console.log(res);

                //   var data = JSON.parse(res);

                //   if(data.status){
                //       swal("Berhasil","Upload berhasil "+data.total_insert+" data","success");
                //       list_jadwal_shift();
                //   }else{
                //       swal("Gagal",data.message,"error");
                //   }
                    console.log(res);

                    var data = JSON.parse(res);

                    if(data.status){

                        let msg = "Upload berhasil "+data.total_insert+" data";

                        if(data.skip_shift > 0){
                            msg += "\nShift kosong : "+data.skip_shift;
                        }

                        if(data.skip_user > 0){
                            msg += "\nUser tidak ditemukan : "+data.skip_user;
                        }

                        if(data.skip_duplicate > 0){
                            msg += "\nData duplikat : "+data.skip_duplicate;
                        }

                        swal("Berhasil", msg, "success");

                        list_jadwal_shift();

                    }else{
                        swal("Gagal",data.message,"error");
                    }
            },

            error:function(){
                swal("Error","Server error","error");
            }

        });

    });
  

</script>