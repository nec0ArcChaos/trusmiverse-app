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
        

        dt_goals(null);
        dt_so(null);
        dt_si(null);





    }); // End of document ready

    function filter_report() {
        year = $('#periode').val();
        if (year == "") {
            // swal("Success!", "Filter Tidak Boleh Kosong!", "success");
            alert("Bulan Dan Tahun Tidak Boleh Kosong");
            console.info("kosong");
        } else {
            console.info("ada " + year + "|");
            dt_goals(year);
            dt_so(year);
            dt_si(year);
        }
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






    function dt_goals(periode) {
        periode = $("#periode").val();
        var table = $('#tbl_goals_master').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            responsive: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>bsc_so/get_dt_goal_master",
                "data": {
                    periode: periode,
                }
            },
            "columns": [
                {
                    "data": "company",
                    "render": function(data, type, row) {
                        if (data == 'Raja Sukses Propertindo') {
                            return 'RSP';
                        } else {
                            return data
                        }
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "department",
                    "render": function(data, type, row) {
                        data = data.charAt(0).toUpperCase() + data.slice(1);
                        if (data == 'Bt') {
                            return data.toUpperCase();
                        } else {
                            return data
                        }
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "perspective",
                    "className": "text-nowrap"
                },
                {
                    "data": "sub",
                    "className": "text-nowrap"
                },
                {
                    "data": "category",
                    "render": function(data, type, row) {
                        // return `<span class="badge bg-light-blue text-dark" onclick="mdl_list_sosi('${row['category']}', '${row['target']}', '${row['actual']}', '${row['tipe']}', '${row['spend']}', '${row['periode']}')"  style="vertical-align:middle;cursor:pointer;">`+data+`</span>`;

                        // replace all _ to space
                        data = data.replace(/_/g, ' ');

                        // camel case
                        data = data.replace(/(\b[a-z])/g, function(x) {
                            return x.toUpperCase();
                        });
                        return `<span class="badge bg-light-blue text-dark" onclick="mdl_add_so('${row['perspective']}', '${row['category']}', '${row['company_id']}', '${row['company']}', '${row['department']}', '${row['periode']}')" style="cursor:pointer;">` + data + `</span>`;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "target",
                    "render": function(data, type, row) {
                        if (row['tipe'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe'] == 'persentase') {
                            return (data);
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-nowrap"

                },
           
                {
                    "data": "tipe",
                },
                {
                    "data": "spend",
                },
                {
                    "data": "project",
                },
                {
                    "data": "pm",
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "employee_name",
                },
              
            ],
        });
    }

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

    function dt_so(periode) {
        periode = $("#periode").val();
        var table = $('#tbl_so_master').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            // "order": [
            //     [14, 'desc']
            // ],
            responsive: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>bsc_so/get_dt_so",
                "data": {
                    periode: periode,
                }
            },
            "columns": [{
                    "data": "company",
                    "render": function(data, type, row) {
                        if (data == 'Raja Sukses Propertindo') {
                            return 'RSP';
                        } else {
                            return data
                        }
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "department",
                    "render": function(data, type, row) {
                        data = data.charAt(0).toUpperCase() + data.slice(1);
                        if (data == 'Bt') {
                            return data.toUpperCase();
                        } else {
                            return data
                        }
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "perspective",
                    "render": function(data, type, row) {
                        return data;
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "category",
                    "render": function(data, type, row) {
                        // replace all _ to space
                        data = data.replace(/_/g, ' ');

                        // camel case
                        data = data.replace(/(\b[a-z])/g, function(x) {
                            return x.toUpperCase();
                        });
                        return data;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "strategy",
                    "render": function(data, type, row) {
                        // return `<span class="badge bg-light-blue text-dark">` + data + `</span>`;
                        return `<span class="badge bg-light-blue text-dark" onclick="mdl_add_si('${row['perspective']}', '${row['category']}', '${row['company_id_so']}', '${row['company']}', '${row['department']}', '${row['id_so']}', '${row['strategy']}', '${row['periode']}')" style="cursor:pointer;">` + data + `</span>`;

                    },
                    "className": "text-nowrap"
                },

                {
                    "data": "target_so",
                    "render": function(data, type, row) {
                        if (row['tipe_so'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_so'] == 'persen') {
                            return (data);
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-nowrap"

                },              
                {
                    "data": "tipe_so",
                },
                {
                    "data": "spend_so",
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "employee_name",
                },
               
            ],
        });
    }

    function dt_si(periode) {
        periode = $("#periode").val();
        var table = $('#tbl_si_master').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            // "order": [
            //     [14, 'desc']
            // ],
            responsive: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>bsc_so/get_dt_si",
                "data": {
                    periode: periode,
                }
            },
            "columns": [{
                    "data": "company",
                    "render": function(data, type, row) {
                        if (data == 'Raja Sukses Propertindo') {
                            return 'RSP';
                        } else {
                            return data
                        }
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "department",
                    "render": function(data, type, row) {
                        data = data.charAt(0).toUpperCase() + data.slice(1);
                        if (data == 'Bt') {
                            return data.toUpperCase();
                        } else {
                            return data
                        }
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "perspective",
                    "render": function(data, type, row) {
                        return data;
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "category",
                    "render": function(data, type, row) {
                        // replace all _ to space
                        data = data.replace(/_/g, ' ');

                        // camel case
                        data = data.replace(/(\b[a-z])/g, function(x) {
                            return x.toUpperCase();
                        });
                        return data;
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "strategy",
                    "render": function(data, type, row) {
                        // return data
                        return `<span class="badge bg-light-blue text-dark">` + data + `</span>`;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "target_si",
                    "render": function(data, type, row) {
                        if (row['tipe_si'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_si'] == 'persen') {
                            return `${data}`;
                        } else {
                            return formatNumber(data);
                        }
                    },
                    "className": "text-nowrap"

                },
               
                {
                    "data": "tipe_si",
                },
                {
                    "data": "spend_si",
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "employee_name",
                },
               
            ],
        });
    }

    function mdl_add_so(perspektive, category, company_id, company, department, periode) {
        $('#mdl_input_so_master').modal('show');
        $('#a_so_company').val(company)
        $('#a_so_company_id').val(company_id)
        $('#a_so_periode').val(periode)
        category_view = category.replace(/_/g, ' ');

        // camel case
        category_view = category_view.replace(/(\b[a-z])/g, function(x) {
            return x.toUpperCase();
        });

        $('#a_so_category_view').val(category_view)
        $('#a_so_category').val(category)

        $('#a_so_perspektif').val(perspektive)
        $('#a_so_department').val(department)

    }

    function btn_save_target_so(){

        a_so_company = $('#a_so_company').val();
        a_so_periode = $('#a_so_periode').val();
        a_so_category = $('#a_so_category').val();
        a_so_department = $('#a_so_department').val();
        a_so_periode = $('#a_so_periode').val();

        a_so_so = $('#a_so_so').val();
        a_so_target = $('#a_so_target').val();

        a_so_spend = $('#a_so_spend :selected').val();
        a_so_tipe = $('#a_so_tipe :selected').val();
        console.info("a_so_tipe " + a_so_tipe);
            
        if (a_so_company == '' || a_so_company == 0) {
            error_alert("Company tidak boleh kosong!");
            $('#a_so_company').focus();
        } else if (a_so_department == '' || a_so_department == 0) {
            error_alert("Department tidak boleh kosong!");
            $('#a_so_department').focus();
        } else if (a_so_so == '' ) {
            error_alert("Strategy harus di isi!");
        } else if (a_so_target == '' || a_so_target == 0) {
            error_alert("Target harus di isi!");
        } else if (a_so_spend == '' || a_so_spend == '0') {
            error_alert("Spend harus di isi!");
        } else if (a_so_tipe == '' || a_so_tipe == '0') {
            error_alert("Tipe harus di isi!");
        
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

                                    $.ajax({
                                        url: `<?= base_url('bsc_so/save_target_so') ?>`,
                                        type: 'POST',
                                        dataType: 'json',
                                        data: $('#form_a_so').serialize(),

                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        $('#tbl_so_master').DataTable().ajax.reload();
                                        $('#mdl_input_so_master').modal('hide');
                                        $('#form_a_so')[0].reset();

                                        if (response.status == true) {
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
                                        } else {
                                            $('#mdl_input_so_master').modal('hide');

                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-xmark',
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


                                    // $('#company').val('');
                                    // $('#department').val('');                                  
                                },

                            });
                        }
                    },
                    cancel: function() {},
                }
            });
        }
    }

    function mdl_add_si(perspektive, category, company_id, company, department, id_so, so, periode) {
        $('#mdl_input_si_master').modal('show');
        $('#a_si_company').val(company)
        $('#a_si_company_id').val(company_id)
        $('#a_si_periode').val(periode)
        $('#a_si_so').val(so)
        $('#a_si_id_so').val(id_so)

        category_view = category.replace(/_/g, ' ');

        // camel case
        category_view = category_view.replace(/(\b[a-z])/g, function(x) {
            return x.toUpperCase();
        });

        $('#a_si_category_view').val(category_view)
        $('#a_si_category').val(category)

        $('#a_si_perspektif').val(perspektive)
        $('#a_si_department').val(department)

    }

    function btn_save_target_si(){

        a_si_company = $('#a_si_company').val();
        a_si_periode = $('#a_si_periode').val();
        a_si_category = $('#a_si_category').val();
        a_si_department = $('#a_si_department').val();
        a_si_periode = $('#a_si_periode').val();

        a_si_si = $('#a_si_si').val();
        a_si_target = $('#a_si_target').val();

        a_si_spend = $('#a_si_spend :selected').val();
        a_si_tipe = $('#a_si_tipe :selected').val();
        console.info("a_si_tipe " + a_si_tipe);
            
        if (a_si_company == '' || a_si_company == 0) {
            error_alert("Company tidak boleh kosong!");
            $('#a_si_company').focus();
        } else if (a_si_department == '' || a_si_department == 0) {
            error_alert("Department tidak boleh kosong!");
            $('#a_so_department').focus();
        } else if (a_si_si == '' ) {
            error_alert("Strategy harus di isi!");
        } else if (a_si_target == '' || a_si_target == 0) {
            error_alert("Target harus di isi!");
        } else if (a_si_spend == '' || a_si_spend == '0') {
            error_alert("Spend harus di isi!");
        } else if (a_si_tipe == '' || a_si_tipe == '0') {
            error_alert("Tipe harus di isi!");

        } else {
            $.confirm({
                title: 'Form Strategy Inisiatif',
                content: 'Simpan Target Inisiatif ?',
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

                                    $.ajax({
                                        url: `<?= base_url('bsc_so/save_target_si') ?>`,
                                        type: 'POST',
                                        dataType: 'json',
                                        data: $('#form_a_si').serialize(),

                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        $('#tbl_si_master').DataTable().ajax.reload();
                                        $('#mdl_input_si_master').modal('hide');
                                        $('#form_a_si')[0].reset();

                                        if (response.status == true) {
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
                                        } else {
                                            $('#mdl_input_si_master').modal('hide');

                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-xmark',
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


                                    // $('#company').val('');
                                    // $('#department').val('');                                  
                                },

                            });
                        }
                    },
                    cancel: function() {},
                }
            });
        }
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

    function updateRupiah(id) {
        let inputField = document.getElementById(id);
        let formattedValue = formatRupiah(inputField.value);
        inputField.value = formattedValue;
    }
</script>