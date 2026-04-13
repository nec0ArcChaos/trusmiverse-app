<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/compressorjs/dist/compressor.min.js"></script>

<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="
https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.umd.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.min.css
" rel="stylesheet">

<!-- Memuat script Dropzone.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script>
    $(document).ready(function() {

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

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

        $('#company').change(function() {
            company_id = $(this).val();

            $.ajax({
                url: '<?php echo base_url(); ?>bsc_so/get_department',
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id
                },
                success: function (response) {
                    slc_department.setData(response);
                    // slc_employee.setData([{text: 'All Employees', value: '0'}])
                }
            });
        });

        $('#department').change(function() {
            department = $(this).val();
            year = $('#periode').val();
            company = $('#company :selected').val();
            // department = $('#department :selected').val();

            if (company == ""){
                alert("company Tidak Boleh Kosong");
            } else if (department == "" ){
                alert("department Tidak Boleh Kosong");
            } else {
                // console.info("ada " + year + "|");

                // $('#btn_save_goals').removeAttr('hidden');
                $('#btn_save_goals').removeClass('btn-success');
                // $('#btn_save_goals').removeAttr('disabled');
                $('#btn_save_goals').addClass('is-invalid');
                $('#btn_save_goals').addClass('btn-disabled');
                $('#btn_save_goals').prop('disabled', true);

                $('#data_place').empty();
                dt_master_goals(company, department);
            }
            
        });

        // filter_company_department();

    }); // End of document ready

    // function filter_company_department() {
    //     year = $('#periode').val();
    //     company = $('#company :selected').val();
    //     department = $('#department :selected').val();

    //     if (company == ""){
    //         alert("company Tidak Boleh Kosong");
    //     } else if (department == "" ){
    //         alert("department Tidak Boleh Kosong");
    //     } else {
    //         console.info("ada " + year + "|");

    //         // $('#btn_save_goals').removeAttr('hidden');
    //         $('#btn_save_goals').removeClass('btn-success');
    //         // $('#btn_save_goals').removeAttr('disabled');
    //         $('#btn_save_goals').addClass('is-invalid');
    //         $('#btn_save_goals').addClass('btn-disabled');
    //         $('#btn_save_goals').prop('disabled', true);
    //         dt_master_goals(company, department);
    //     }
    // }

    function dt_master_goals(company, department) {
        periode = $("#periode").val();
        var table = $('#tbl_goal_m').DataTable({
            // orderCellsTop: true,
            // fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            // "order": [
            //     [14, 'desc']
            // ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>bsc_so/get_dt_master_goals",
                "data": {
                    company: company,
                    department: department,

                }
            },
            "columns": [                              
                {
                    "data": "perspective",
                    "render": function(data, type, row, meta) {
                        return data + `<input type="hidden" id="add_perspective_` + meta.row + `" name="add_perspective[]" value="`+data+`">`+
                        `<input type="hidden" id="add_company_id_` + meta.row + `" name="add_company_id[]" value="`+row['company_id']+`">`+
                        `<input type="hidden" id="add_department_` + meta.row + `" name="add_department[]" value="`+row['department']+`">`+
                        `<input type="hidden" id="add_datas_` + meta.row + `" name="add_datas[]" value="`+row['datas']+`">`;
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "sub",
                    "render": function(data, type, row, meta) {
                        return data + `<input type="hidden" id="add_sub_` + meta.row + `" name="add_sub[]" value="`+data+`">`;
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "category",
                    "render": function(data, type, row, meta) {
                        // replace all _ to space
                        data = data.replace(/_/g, ' ');

                        // camel case
                        data = data.replace(/(\b[a-z])/g, function(x) {
                            return x.toUpperCase();
                        });
                        return `<span class="badge bg-light-blue text-dark">` + data + `</span>`+
                        `<input type="hidden" id="add_category_` + meta.row + `" name="add_category[]" value="`+row['category']+`">`;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "target",
                    "render": function(data, type, row, meta) {
                        style="padding: 8px;font-size: 16px;    border: 2px solid #3498db;border-radius: 4px;transition: border-color 0.3s ease;"
                        // return `<input type="text" id="v_target_goals_` + meta.row + `" name="v_target_goals_` + meta.row + `" style="`+style+`" placeholder=0 onkeyup="updateRupiahTarget('v_target_goals_` + meta.row + `', `+meta.row+`)">`;
                        return `<input type="text" id="v_target_goals_` + meta.row + `" name="add_target[]" style="`+style+`" placeholder=0 onkeyup="updateRupiahTarget('v_target_goals_` + meta.row + `', `+meta.row+`)">`;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "bobot",
                    "render": function(data, type, row, meta) {
                        style="padding: 10px;font-size: 16px;    border: 2px solid #3498db;border-radius: 4px;transition: border-color 0.3s ease;"
                        // return `<input type="text" id="v_bobot_goals_` + meta.row + `" name="v_bobot_goals_` + meta.row + `" style="`+style+`" placeholder=0 onkeyup="updateRupiahBobot('v_bobot_goals_` + meta.row + `', `+meta.row+`)">`;
                        return `<input type="text" id="v_bobot_goals_` + meta.row + `" name="add_bobot[]" style="`+style+`" placeholder=0 onkeyup="updateRupiahBobot('v_bobot_goals_` + meta.row + `', `+meta.row+`)">`;

                    },
                    "className": "text-nowrap"
                },
               
                {
                    "data": "tipe",
                    "render": function(data, type, row, meta) {
                        return `<select name="add_tipe[]" id="Message: Uninitialized string offset: 3" class="form-control border-start-0">
                                    <option value="0" ${data === '' ? 'selected' : ''}>-Belum Dipilih-</option>
                                    <option value="qty"  ${data === 'qty' ? 'selected' : ''}>qty</option>
                                    <option value="nominal"  ${data === 'nominal' ? 'selected' : ''}>nominal</option>
                                    <option value="persent"  ${data === 'persent' ? 'selected' : ''}>persent</option>
                                    <option value="percent"  ${data === 'percent' ? 'selected' : ''}>percent</option>
                                </select>`
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "spend",
                    "render": function(data, type, row, meta) {
                        return `<select name="add_spend[]" id="add_spend" class="form-control border-start-0">
                                    <option value="0" ${data === '' ? 'selected' : ''}>-Belum Dipilih-</option>
                                    <option value="over"  ${data === 'over' ? 'selected' : ''}>over</option>
                                    <option value="under"  ${data === 'under' ? 'selected' : ''}>under</option>
                                    
                                </select>`
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "project",
                    "render": function(data, type, row, meta) {

                        style="padding: 10px;font-size: 16px;    border: 2px solid #3498db;border-radius: 4px;transition: border-color 0.3s ease;"
                        if($('#company :selected').val() == 2 && row['department'] == 'Project'){
                            return `<input type="text" id="v_project_goals_` + meta.row + `" name="add_project[]" value="`+row['project']+`"  style="`+style+`">`;
                        } else {
                            return `<input type="hidden" id="v_project_goals_` + meta.row + `" name="add_project[]" value="`+row['project']+`" style="`+style+`" readonly>`;
                        }
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "pm",
                    "render": function(data, type, row, meta) {
                        style="padding: 10px;font-size: 16px;    border: 2px solid #3498db;border-radius: 4px;transition: border-color 0.3s ease;"

                        if($('#company :selected').val() == 2 && row['department'] == 'Project'){
                            return `<input type="text" id="v_pm_goals_` + meta.row + `" name="add_pm[]" value="`+row['pm']+`" style="`+style+`">`;
                        } else {
                            return `<input type="hidden" id="v_pm_goals_` + meta.row + `" name="add_pm[]" value="`+row['pm']+`" readonly>`;

                        }
                    },
                    "className": "text-nowrap"
                },
            ],          
            "initComplete" : function(settings, data){
                // input_hidden    = '';
                // add_perspective       = '';
                // add_sub     = '';
                // add_category      = '';
                // add_project     = '';
                // add_pm          = '';
                // add_target             = '';
                // add_bobot   = '';
                // add_department   = '';
                // add_tipe   = '';
                // add_spend   = '';
                // add_company_id   = '';
                // add_datas   = '';

                // jumlah          = '';

                // console.log(data.data.length);
                // for (i = 0; i < data.data.length; i++) {

                    // add_perspective += '<input type="hidden" id="add_perspective_'+i+'" class="hidden_'+i+' add_perspective" name="add_perspective[]" value="'+data.data[i].perspective+'">';
                    // $('.add_perspective').remove();
                    // $('#data_place').append(add_perspective);
                    // add_sub += '<input type="hidden" id="add_sub_'+i+'" class="hidden_'+i+' add_sub" name="add_sub[]" value="'+data.data[i].sub+'">';
                    // $('.add_sub').remove();
                    // $('#data_place').append(add_sub);
                    // add_category += '<input type="hidden" id="add_category_'+i+'" class="hidden_'+i+' add_category" name="add_category[]" value="'+data.data[i].category+'">';
                    // $('.add_category').remove();
                    // $('#data_place').append(add_category);
                    // add_project += '<input type="hidden" id="add_project_'+i+'" class="hidden_'+i+' add_project" name="add_project[]" value="'+data.data[i].project+'">';
                    // $('.add_project').remove();
                    // $('#data_place').append(add_project);
                    // add_pm += '<input type="hidden" id="add_pm_'+i+'" name="add_pm[]" value="'+data.data[i].pm+'">';
                    // $('.add_pm').remove();
                    // $('#data_place').append(add_pm); 

                    // add_target += '<input type="hidden" id="add_target_'+i+'" class="add_target add_target_hidden" name="add_target[]" value="0">';
                    // $('.add_target').remove();
                    // $('#data_place').append(add_target);


                    // add_bobot += '<input type="hidden" id="add_bobot_'+i+'" class="hidden_'+i+' add_bobot" name="add_bobot[]" value="0">';
                    // $('.add_bobot').remove();
                    // $('#data_place').append(add_bobot);
                    // add_department += '<input type="hidden" id="add_department_'+i+'" class="hidden_'+i+' add_department" name="add_department[]" value="'+data.data[i].department+'">';
                    // $('.add_department').remove();
                    // $('#data_place').append(add_department);
                    // add_tipe += '<input type="hidden" id="add_tipe_'+i+'" class="hidden_'+i+' add_tipe" name="add_tipe[]" value="'+data.data[i].tipe+'">';
                    // $('.add_tipe').remove();
                    // $('#data_place').append(add_tipe);
                    // add_spend += '<input type="hidden" id="add_spend_'+i+'" class="hidden_'+i+' add_spend" name="add_spend[]" value="'+data.data[i].spend+'">';
                    // $('.add_spend').remove();
                    // $('#data_place').append(add_spend);
                    // add_company_id += '<input type="hidden" id="add_company_id_'+i+'" class="hidden_'+i+' add_company_id" name="add_company_id[]" value="'+data.data[i].company_id+'">';
                    // $('.add_company_id').remove();
                    // $('#data_place').append(add_company_id);
                    // add_datas += '<input type="hidden" id="add_datas_'+i+'" class="hidden_'+i+' add_datas" name="add_datas[]" value="'+data.data[i].datas+'">';
                    // $('.add_datas').remove();
                    // $('#data_place').append(add_datas);
                // }
                // $('#data_place').empty();
                // $('#data_place').append(input_hidden);

                    // jumlah = '<input type="hidden" id="jumlah" class="jumlah" name="jumlah" value="'+jml_gr+'">';
                    // $('.jumlah').remove();
                    // $('#data_place').append(jumlah);
                    setTimeout(() => {
                        $('#btn_save_goals').removeAttr('hidden');
                        $('#btn_save_goals').removeClass('is-invalid');
                        $('#btn_save_goals').removeClass('btn-disabled');
                        $('#btn_save_goals').addClass('btn-success');
                        $('#btn_save_goals').removeAttr('disabled');
                        $('#btn_save_goals').prop('disabled', false);
                    }, 1000);
            }   
        });
    }

    function formatNumber2(number) {
        // Convert the number to string and split it by the decimal point
        var parts = number.toString().split(".");
        // Replace every three digits with itself followed by a comma
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // Join the parts back together with the comma
        return parts.join(".");
    }

    function slim(selectId, placeholderText) {
        new SlimSelect({
            select: selectId,
            settings: {
                placeholderText: placeholderText,
            }
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 1500,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }


    function save_goals() {
        // goal_id = $('#goal_id').val()
        // goal_category = $('#goal_category').val()
        // goal_perspektive = $('#goal_perspektive').val()
        // goal_sub = $('#goal_sub').val()
        // goal_id_company = $('#goal_id_company').val()

        // goal_resume = $('#goal_resume').val();
        // goal_target = $('#goal_target').val();

        // goal_actual = $('#goal_actual').val();
        // goal_acv = parseFloat((parseInt(goal_actual) / parseInt(goal_target)) * 100).toFixed();
        // console.info(goal_target);
        // console.info(goal_actual);

        // console.info(goal_acv);
        // goal_periode = $('#goal_periode').val();
        // goal_link = $('#goal_link').val();

        // goal_file = document.getElementById('goal_file').files;
        company = $('#company :selected').val();
        department = $('#department :selected').val();
        year = $('#periode').val();

        if (company == '' || company == 0) {
            error_alert("Company tidak boleh kosong!");
            $('#company').focus();
        } else if (department == '' || department == 0) {
            error_alert("Department tidak boleh kosong!");
            $('#department').focus();
        } else if (year == '' ) {
            error_alert("Tahun dan bulan harus di isi!");
        } else {
            $.confirm({
                title: 'Form Goal',
                content: 'Simpan Target Goals ?',
                icon: 'fa fa-question',
                theme: 'material',
                animation: 'scale',
                closeAnimation: 'scale',
                animateFromElement: false,
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


                                    // const formData = new FormData();
                                    // The third parameter is required for server

                                    $.ajax({
                                        url: `<?= base_url('bsc_so/save_list_goals') ?>`,
                                        type: 'POST',
                                        dataType: 'json',
                                        // data: formData,
                                        data: $('#form_add_goals').serialize(),
                                        // cache: false,
                                        // contentType: false,
                                        // processData: false,
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        // dt_det_goal(goal_id, periode);
                                        // $('#tbl_goal').DataTable().ajax.reload();
                                        // $('#tbl_goal_h').DataTable().ajax.reload();
                                        // window.location.href = "<?php echo site_url('bsc_so/add_list_goals') ?>";
                                        // console.info("cek_data " + response.cek_data);
                                        // console.info("cek_data " + response.insert_detail);
                                        // console.info("hasil_cek_text " + response.hasil_cek_text);
                                        // console.info("hasil_cek_text " + response.list_double);



                                        if(response.cek_data_tidak_double == false){
                                            // alert("data berikut sudah ada di periode yang di pilih : \n" +response.hasil_cek_text);

                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-xmark',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: "data berikut sudah ada di periode yang di pilih : \n" + response.list_double,
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
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


                                    $('#company').val('');
                                    $('#department').val('');                                  
                                },

                            });
                        }
                    },
                    cancel: function() {},
                }
            });
        }
    }





    //
    //

    //
    //
    //
    //
    //
    //
    //
    //






    function formatNumber(num) {
        if (num == null || isNaN(num)) {
            return num;
        }
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }

    function expandTextarea_draft(id) {
        document.getElementById(id).addEventListener('keyup', function() {
            this.style.overflow = 'hidden';
            this.style.height = 0;
            this.style.height = this.scrollHeight + 'px';
        }, false);
    }

</script>

<script>
    function camelize(str) {
        return str.replace(/(?:^\w|[A-Z]|\b\w|\s+)/g, function(match, index) {
            if (+match === 0) return ""; // or if (/\s+/.test(match)) for white spaces
            return index === 0 ? match.toLowerCase() : match.toUpperCase();
        });
    }

    function formatRupiah(input) {
        let numberString = input.replace(/[^,\d]/g, '').toString(),
            split = numberString.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    function updateRupiahTarget(id, meta_row) {
        let inputField = document.getElementById(id);
       
        let formattedValue = formatRupiah(inputField.value);
        inputField.value = formattedValue;
       
        // console.info("meta_row " + meta_row);
        $("#add_target_"+meta_row).val(inputField.value);
        
    }

    function updateRupiahBobot(id, meta_row) {
        let inputField = document.getElementById(id);
       
        let formattedValue = formatRupiah(inputField.value);
        inputField.value = formattedValue;
       
        // console.info("meta_row " + meta_row);
        $("#add_bobot_"+meta_row).val(inputField.value);
        
    }
</script>