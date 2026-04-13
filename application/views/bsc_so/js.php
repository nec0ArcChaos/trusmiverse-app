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

        dt_sosi(null);
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
            dt_sosi(year);
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






    function dt_sosi(periode) {
        periode = $("#periode").val();
        var table = $('#tbl_goal_h').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [14, 'desc']
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
                "url": "<?= base_url(); ?>bsc_so/get_dt_goal_h",
                "data": {
                    periode: periode,
                    goal_id: null,

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
                        return `<span class="badge bg-light-blue text-dark">` + data + `</span>`;

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
                    "data": "actual_h",
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
                    "data": "deviasi_h",
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
                }, {
                    "data": "persentase_h",
                    "render": function(data, type, row) {

                        // return (data) + ` %`;
                        return `<span class="text-` + row['persen_panah'] + `">` + data + ` %</span>`;

                    },
                    "className": "text-nowrap"
                },

                {
                    "data": "lampiran_h",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_h'] != '' && row['lampiran_h'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_h']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_h']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_h']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_h",
                    "render": function(data, type, row, meta) {
                        if (row['link_h'] != '' && row['link_h'] != null) {
                            return `<a href="${row['link_h']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "tipe",
                },
                {
                    "data": "spend",
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "employee_name",
                },
                {
                    "data": "resume_h",
                }
            ],
        });
    }

    // function mdl_list_sosi(category, target, actual, tipe, spend, periode) {
    //     console.info(category);
    //     $("#i_target").val(target);
    //     $("#i_actual").val(actual);
    //     $("#i_tipe").val(tipe);
    //     $("#i_spend").val(spend);
    //     $("#i_periode").val(periode);

    //     $('#modal_input_ketercapaian').modal('show');
    //             $.ajax({
    //             url: '<?php echo base_url() ?>bsc_so/get_strategi_sosi/'+category,
    //             type: 'GET',
    //             dataType: 'JSON',
    //             cache: false,
    //             })
    //             .done(function(data) {
    //                 $('#data_so').empty().html(data.table);



    //                 // Kondisi Data Resultnya
    //                 console.log('Data : ',data);



    //                 })
    //                 .fail(function(xhr) {
    //                 console.log("error", xhr.responseText);
    //                 })
    //                 .always(function() {
    //                 console.log("complete");
    //                 });
    // }


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
        var table = $('#tbl_so_h').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [14, 'desc']
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
                "url": "<?= base_url(); ?>bsc_so/get_dt_so_h",
                "data": {
                    periode: periode,
                    id_so: null,

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
                // {
                //     "data": "strategy",
                //         "render": function(data, type, row) {                          
                //                 return data

                //         },
                //         "className": "text-right"
                // },
                {
                    "data": "strategy",
                    "render": function(data, type, row) {
                        return `<span class="badge bg-light-blue text-dark">` + data + `</span>`;

                    },
                    "className": "text-nowrap"
                },
                // {
                //     "data": "category",
                //         "render": function(data, type, row) {
                //             return `<span class="badge bg-light-blue text-dark" onclick="mdl_list_sosi('${row['category']}', '${row['target']}', '${row['actual']}', '${row['tipe']}', '${row['spend']}', '${row['periode']}')"  style="vertical-align:middle;cursor:pointer;">`+data+`</span>`;
                //         },
                //         "className": "text-nowrap"
                // },
                {
                    "data": "target_so_h",
                    "render": function(data, type, row) {
                        if (row['tipe_so'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_so'] == 'persentase') {
                            return (data);
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "actual_so_h",
                    "render": function(data, type, row) {
                        if (row['tipe_so'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_so'] == 'persentase') {
                            return (data);
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "achieve_so_h",
                    "render": function(data, type, row) {
                        // if(row['achieve_so'] >= 0){
                        //     return (data) + ` %`;
                        // } else {
                        //     return (data);
                        // }

                        return `<span class="text-` + row['persen_panah'] + `">` + data + ` %</span>`;

                    },
                    "className": "text-nowrap"
                },

                {
                    "data": "status_so_h",
                    "render": function(data, type, row) {
                        if (data == 'Berhasil') {
                            return `<span class="text-success">` + data + `</span>`;
                        } else if (data == 'Tidak Berhasil') {
                            return `<span class="text-danger">` + data + `</span>`;
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-right"
                },
                {
                    "data": "lampiran_so_h",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_so_h'] != '' && row['lampiran_so_h'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_so_h']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_so_h']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_so_h']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_so_h",
                    "render": function(data, type, row, meta) {
                        if (row['link_so_h'] != '' && row['link_so_h'] != null) {
                            return `<a href="${row['link_so_h']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
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
                {
                    "data": "resume_so_h",
                }
            ],
        });
    }

    function mdl_list_so() {
        periode = $("#periode").val();
        $('#mdl_strategi_objektif').modal('show');
        var table = $('#tbl_so').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                    "className": "text-right"
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
                        return data
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "strategy",
                    "render": function(data, type, row) {
                        return `<span class="badge bg-primary" onclick="mdl_input_so('${row['category']}','${row['id_so']}','${row['strategy']}', '${row['target_so']}', '${row['actual_so']}', '${row['tipe_so']}', '${row['spend_so']}', '${row['company_id_so']}', '${row['periode']}')"  style="vertical-align:middle;cursor:pointer;">` + data + `</span>`;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "target_so",
                    "render": function(data, type, row) {
                        if (row['tipe_so'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_so'] == 'persentase') {
                            return (data);
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "actual_so",
                    "render": function(data, type, row) {
                        if (row['tipe_so'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_so'] == 'persentase') {
                            return (data);
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "achieve_so",
                    "render": function(data, type, row) {
                        // if(row['achieve_so'] >= 0){
                        return `<span class="text-` + row['persen_panah'] + `">` + data + ` %</span>`;
                        // } else {
                        //     return `<span class="text-success">`+data+`</span>` ;
                        // }
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
                    "data": "status_so",
                    "render": function(data, type, row) {
                        if (data == 'Berhasil') {
                            return `<span class="text-success">` + data + `</span>`;
                        } else if (data == 'Tdk Berhasil') {
                            return `<span class="text-danger">` + data + `</span>`;
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-right"
                },
                // {
                //     "data": "lampiran_so",
                // },
                // {
                //     "data": "link_so",
                // },
                {
                    "data": "lampiran_so",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_so'] != '' && row['lampiran_so'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_so']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_so']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_so']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_so",
                    "render": function(data, type, row, meta) {
                        if (row['link_so'] != '' && row['link_so'] != null) {
                            return `<a href="${row['link_so']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
                },
            ],
        });
    }

    function mdl_input_so(category, id_so, strategy, target, actual, tipe, spend, company_id_so, periode) {
        $('#mdl_input_so').modal('show');
        $('#so_category').val(category);
        $('#so_strategy').val(strategy);

        $('#so_id_so').val(id_so);
        $('#so_company_id_so').val(company_id_so);

        $('#so_periode').val(periode);
        $('#so_target').val(target);
        $('#so_target_text').val(formatNumber(target));
        $('#so_actual').val('');

        dt_det_so(id_so, periode);

    }

    function save_actual_so() {
        so_id_so = $('#so_id_so').val()
        so_category = $('#so_category').val()
        so_company_id_so = $('#so_company_id_so').val();

        so_status = $('input[name="so_status"]:checked').val();
        so_resume = $('#so_resume').val();
        so_target = $('#so_target').val();

        so_actual = $('#so_actual').val();
        so_acv = parseFloat((parseInt(so_actual) / parseInt(so_target)) * 100).toFixed();
        console.info(so_target);
        console.info(so_actual);

        console.info(so_acv);
        periode = $('#so_periode').val();
        so_link = $('#so_link').val();

        so_file = document.getElementById('so_file').files;

        if (!so_id_so) {
            error_alert("Ketercapaian Kosong, silahkan refresh dahulu!");
            $('#so_id_so').focus();
        } else if (so_status == '') {
            error_alert("Status tidak boleh kosong!");
            $('#so_status').focus();
        } else if (so_resume == '') {
            error_alert("Resume tidak boleh kosong!");
            $('#so_resume').focus();
        } else if (so_actual == '') {
            error_alert("Actual tidak boleh kosong!");
            $('#so_actual').focus();
        } else if (document.getElementById("so_file").files.length == 0 && so_link == '') {
            error_alert("Bukti File/Link salah satu harus di isi!");
        } else {
            $.confirm({
                title: 'Form SO',
                content: 'Simpan Pencapaian SO ?',
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


                                    if (document.getElementById("so_file").files.length == 0) {
                                        const formData = new FormData();
                                        // The third parameter is required for server
                                        formData.append("so_id_so", so_id_so);
                                        formData.append("so_category", so_category);
                                        formData.append("so_status", so_status);
                                        formData.append("so_company_id_so", so_company_id_so);

                                        formData.append("so_resume", so_resume);
                                        formData.append("so_target", so_target);
                                        formData.append("so_acv", so_acv);
                                        formData.append("periode", periode);

                                        formData.append("so_actual", so_actual);
                                        formData.append("so_link", so_link);
                                        formData.append('so_file', '');


                                        $.ajax({
                                            url: `<?= base_url('bsc_so/insert_so') ?>`,
                                            type: 'POST',
                                            dataType: 'json',
                                            data: formData,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            beforeSend: function() {

                                            },
                                            success: function(response) {},
                                            error: function(xhr) {},
                                            complete: function() {},
                                        }).done(function(response) {
                                            dt_det_so(so_id_so, periode)
                                            $('#tbl_so').DataTable().ajax.reload();
                                            $('#tbl_so_h').DataTable().ajax.reload();
                                            if (response.update == true) {
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
                                    } else {
                                        // Dapatkan elemen input file
                                        const fileInput = document.getElementById('so_file');

                                        // Dapatkan file yang dipilih langsung dari elemen input file
                                        const file = fileInput.files[0];
                                        new Compressor(file, {
                                            quality: 0.6,

                                            // The compression process is asynchronous,
                                            // which means you have to access the `result` in the `success` hook function.
                                            success(result) {
                                                console.log(result);
                                                const formData = new FormData();
                                                // The third parameter is required for server
                                                formData.append("so_id_so", so_id_so);
                                                formData.append("so_category", so_category);
                                                formData.append("so_company_id_so", so_company_id_so);

                                                formData.append("so_status", so_status);
                                                formData.append("so_resume", so_resume);
                                                formData.append("so_target", so_target);
                                                formData.append("so_actual", so_actual);
                                                formData.append("so_acv", so_acv);
                                                formData.append("periode", periode);

                                                formData.append("so_link", so_link);
                                                formData.append('so_file', result, result.name);


                                                $.ajax({
                                                    url: `<?= base_url('bsc_so/insert_so') ?>`,
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: formData,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    beforeSend: function() {

                                                    },
                                                    success: function(response) {},
                                                    error: function(xhr) {},
                                                    complete: function() {},
                                                }).done(function(response) {
                                                    dt_det_so(so_id_so, periode);
                                                    $('#tbl_so').DataTable().ajax.reload();
                                                    $('#tbl_so_h').DataTable().ajax.reload();
                                                    if (response.update == true) {
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
                                            },
                                            error(err) {
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: err.message,
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            },
                                        });
                                    }

                                    $('#so_resume').val('');
                                    $('#so_actual').val('');
                                    $('#so_link').val('');
                                    $('#so_file').val('');

                                },

                            });
                        }
                    },
                    cancel: function() {},
                }
            });
        }
    }

    function dt_det_so(id_so, periode) {
        var table = $('#tbl_det_so').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                "url": "<?= base_url(); ?>bsc_so/get_dt_so_h",
                "data": {
                    periode: periode,
                    id_so: id_so,

                }
            },
            "columns": [{
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "employee_name",
                    "className": "text-nowrap"
                },
                {
                    "data": "status_so_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "actual_so_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "resume_so_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "lampiran_so_h",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_so_h'] != '' && row['lampiran_so_h'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_so_h']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_so_h']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_so_h']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_so_h",
                    "render": function(data, type, row, meta) {
                        if (row['link_so_h'] != '' && row['link_so_h'] != null) {
                            return `<a href="${row['link_so_h']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "created_at",
                    "className": "text-nowrap"
                },
            ],
        });
    }

    function dt_si(periode) {
        periode = $("#periode").val();
        var table = $('#tbl_si_h').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [14, 'desc']
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
                "url": "<?= base_url(); ?>bsc_so/get_dt_si_h",
                "data": {
                    periode: periode,
                    id_so: null,
                    id_si: null,


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
                    "data": "target_si_h",
                    "render": function(data, type, row) {
                        if (row['tipe_si'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_si'] == 'persentase') {
                            return `${data}`;
                        } else {
                            return formatNumber(data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "actual_si_h",
                    "render": function(data, type, row) {
                        if (row['tipe_si'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_si'] == 'persentase') {
                            return `${data}`;
                        } else {
                            return formatNumber(data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "achieve_si_h",
                    "render": function(data, type, row) {
                        if (row['achieve_si'] >= 0) {
                            return (data) + ` %`;
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-nowrap"
                },

                {
                    "data": "status_si_h",
                    "render": function(data, type, row) {
                        if (data == 'Berhasil') {
                            return `<span class="text-success">` + data + `</span>`;
                        } else if (data == 'Jalan Tdk Berhasil') {
                            return `<span class="text-warning">` + data + `</span>`;
                        } else if (data == 'Tdk Berhasil') {
                            return `<span class="text-danger">` + data + `</span>`;
                        } else if (data == 'Progress') {
                            return `<span class="text-primary">` + data + `</span>`;
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-right"
                },
                {
                    "data": "lampiran_si_h",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_si_h'] != '' && row['lampiran_si_h'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_si_h']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_si_h']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_si_h']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_si_h",
                    "render": function(data, type, row, meta) {
                        if (row['link_si_h'] != '' && row['link_si_h'] != null) {
                            return `<a href="${row['link_si_h']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
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
                {
                    "data": "resume_si_h",
                }
            ],
        });
    }

    function mdl_list_si() {
        periode = $("#periode").val();
        $('#mdl_strategi_inisiatid').modal('show');
        var table = $('#tbl_si').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                    "className": "text-right"
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
                        return data
                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "strategy",
                    "render": function(data, type, row) {
                        return `<span class="badge bg-primary" onclick="mdl_input_si('${row['category']}','${row['id_so']}','${row['id_si']}', '${row['strategy']}', '${row['target_si']}', '${row['actual_si']}', '${row['tipe_si']}', '${row['spend_si']}', '${row['periode']}')"  style="vertical-align:middle;cursor:pointer;">` + data + `</span>`;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "target_si",
                    "render": function(data, type, row) {
                        if (row['tipe_si'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_si'] == 'persentase') {
                            return `${data}`;
                        } else {
                            return formatNumber(data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "actual_si",
                    "render": function(data, type, row) {
                        if (row['tipe_si'] == 'nominal') {
                            return `Rp ` + formatNumber(data);
                        } else if (row['tipe_si'] == 'persentase') {
                            return `${data}`;
                        } else {
                            return formatNumber(data);
                        }
                    },
                    "className": "text-nowrap"

                },
                {
                    "data": "achieve_si",
                    "render": function(data, type, row) {
                        // if(row['achieve_si'] >= 0){
                        //     return (data) + ` %`;
                        // } else {
                        //     return (data);
                        // }
                        return `<span class="text-` + row['persen_panah'] + `">` + data + ` %</span>`;

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
                    "data": "status_si",
                    "render": function(data, type, row) {
                        if (data == 'Berhasil') {
                            return `<span class="text-success">` + data + `</span>`;
                        } else if (data == 'Jalan Tdk Berhasil') {
                            return `<span class="text-warning">` + data + `</span>`;
                        } else if (data == 'Tdk Berhasil') {
                            return `<span class="text-danger">` + data + `</span>`;
                        } else if (data == 'Progress') {
                            return `<span class="text-primary">` + data + `</span>`;
                        } else {
                            return (data);
                        }
                    },
                    "className": "text-right"
                },
                {
                    "data": "lampiran_si",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_si'] != '' && row['lampiran_si'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_si']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_si']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_si']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_si",
                    "render": function(data, type, row, meta) {
                        if (row['link_si'] != '' && row['link_si'] != null) {
                            return `<a href="${row['link_si']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
                },
            ],
        });
    }

    function mdl_input_si(category, id_so, id_si, si_strategy, target, actual, tipe, spend, periode) {
        $('#mdl_input_si').modal('show');
        console.info("mdl_input_si");
        $('#si_category').val(category);
        $('#si_strategy').val(si_strategy);


        $('#si_id_so').val(id_so);
        $('#si_id_si').val(id_si);

        $('#si_periode').val(periode);
        $('#si_target').val(target);
        $('#si_target_text').val(formatNumber(target));
        $('#si_actual').val('');

        dt_det_si(id_so, id_si, periode);

    }

    function save_actual_si() {
        si_id_so = $('#si_id_so').val()
        si_id_si = $('#si_id_si').val()

        si_category = $('#si_category').val()

        si_status = $('input[name="si_status"]:checked').val();
        si_resume = $('#si_resume').val();
        si_target = $('#si_target').val();

        si_actual = $('#si_actual').val();
        si_acv = parseFloat((parseInt(si_actual) / parseInt(si_target)) * 100).toFixed();
        console.info(si_target);
        console.info(si_actual);

        console.info(si_acv);
        periode = $('#si_periode').val();
        si_link = $('#si_link').val();

        si_file = document.getElementById('si_file').files;

        if (!si_id_so) {
            error_alert("Ketercapaian Kosong, silahkan refresh dahulu!");
            $('#si_id_so').focus();
        } else if (si_status == '') {
            error_alert("Status tidak boleh kosong!");
            $('#si_status').focus();
        } else if (si_resume == '') {
            error_alert("Resume tidak boleh kosong!");
            $('#si_resume').focus();
        } else if (si_actual == '') {
            error_alert("Actual tidak boleh kosong!");
            $('#si_actual').focus();
        } else if (document.getElementById("si_file").files.length == 0 && si_link == '') {
            error_alert("Bukti File/Link salah satu harus di isi!");
        } else {
            $.confirm({
                title: 'Form SI',
                content: 'Simpan Pencapaian SI ?',
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


                                    if (document.getElementById("si_file").files.length == 0) {
                                        const formData = new FormData();
                                        // The third parameter is required for server
                                        formData.append("si_id_so", si_id_so);
                                        formData.append("si_id_si", si_id_si);
                                        formData.append("si_category", si_category);
                                        formData.append("si_status", si_status);

                                        formData.append("si_resume", si_resume);
                                        formData.append("si_target", si_target);
                                        formData.append("si_acv", si_acv);
                                        formData.append("periode", periode);

                                        formData.append("si_actual", si_actual);
                                        formData.append("si_link", si_link);
                                        formData.append('si_file', '');


                                        $.ajax({
                                            url: `<?= base_url('bsc_so/insert_si') ?>`,
                                            type: 'POST',
                                            dataType: 'json',
                                            data: formData,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            beforeSend: function() {

                                            },
                                            success: function(response) {},
                                            error: function(xhr) {},
                                            complete: function() {},
                                        }).done(function(response) {
                                            dt_det_si(si_id_so, si_id_si, periode)
                                            $('#tbl_si').DataTable().ajax.reload();
                                            $('#tbl_si_h').DataTable().ajax.reload();

                                            if (response.update == true) {
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
                                    } else {
                                        // Dapatkan elemen input file
                                        const fileInput = document.getElementById('si_file');

                                        // Dapatkan file yang dipilih langsung dari elemen input file
                                        const file = fileInput.files[0];
                                        new Compressor(file, {
                                            quality: 0.6,

                                            // The compression process is asynchronous,
                                            // which means you have to access the `result` in the `success` hook function.
                                            success(result) {
                                                console.log(result);
                                                const formData = new FormData();
                                                // The third parameter is required for server
                                                formData.append("si_id_so", si_id_so);
                                                formData.append("si_id_si", si_id_si);

                                                formData.append("si_category", si_category);

                                                formData.append("si_status", si_status);
                                                formData.append("si_resume", si_resume);
                                                formData.append("si_target", si_target);
                                                formData.append("si_actual", si_actual);
                                                formData.append("si_acv", si_acv);
                                                formData.append("periode", periode);


                                                formData.append("si_link", si_link);
                                                formData.append('si_file', result, result.name);


                                                $.ajax({
                                                    url: `<?= base_url('bsc_so/insert_si') ?>`,
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: formData,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    beforeSend: function() {

                                                    },
                                                    success: function(response) {},
                                                    error: function(xhr) {},
                                                    complete: function() {},
                                                }).done(function(response) {
                                                    dt_det_si(si_id_so, si_id_si, periode)
                                                    $('#tbl_si').DataTable().ajax.reload();
                                                    $('#tbl_si_h').DataTable().ajax.reload();

                                                    if (response.update == true) {
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
                                            },
                                            error(err) {
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: err.message,
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            },
                                        });
                                    }

                                    $('#si_resume').val('');
                                    $('#si_actual').val('');
                                    $('#si_link').val('');
                                    $('#si_file').val('');

                                },

                            });
                        }
                    },
                    cancel: function() {},
                }
            });
        }
    }

    function dt_det_si(id_so, id_si, periode) {
        var table = $('#tbl_det_si').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                "url": "<?= base_url(); ?>bsc_so/get_dt_si_h",
                "data": {
                    periode: periode,
                    id_so: id_so,
                    id_si: id_si,


                }
            },
            "columns": [{
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "employee_name",
                    "className": "text-nowrap"
                },
                {
                    "data": "status_si_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "actual_si_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "resume_si_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "lampiran_si_h",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_si_h'] != '' && row['lampiran_si_h'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_si_h']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_si_h']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_si_h']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_si_h",
                    "render": function(data, type, row, meta) {
                        if (row['link_si_h'] != '' && row['link_si_h'] != null) {
                            return `<a href="${row['link_si_h']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "created_at",
                    "className": "text-nowrap"
                },
            ],
        });
    }


    function mdl_list_goal() {
        $('#mdl_goal').modal('show');

        periode = $("#periode").val();
        var table = $('#tbl_goal').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                "url": "<?= base_url(); ?>bsc_so/get_dt_goal",
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
                    "className": "text-nowrap"
                },
                {
                    "data": "sub",
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
                        return `<span class="badge bg-light-blue text-dark" onclick="mdl_input_goal('${row['id']}', '${row['category']}', '${row['target']}', '${row['actual']}', '${row['tipe']}', '${row['spend']}', '${row['periode']}')"  style="vertical-align:middle;cursor:pointer;">` + data + `</span>`;
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
                    "data": "actual",
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
                    "data": "deviasi",
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
                }, {
                    "data": "persentase",
                    "render": function(data, type, row) {

                        // return (data) + ` %`;
                        return `<span class="text-` + row['persen_panah'] + `">` + data + ` %</span>`;

                    },
                    "className": "text-nowrap"
                },
                {
                    "data": "tipe",
                },
                {
                    "data": "spend",
                }
            ],
        });
    }

    function mdl_input_goal(goal_id, category, goal_target, actual, tipe, spend, goal_periode) {
        console.info(goal_id);
        $("#goal_id").val(goal_id);
        $("#goal_target").val(goal_target);
        $("#goal_periode").val(goal_periode);

        // replace all _ to space
        category = category.replace(/_/g, ' ');
        // camel case
        category = category.replace(/(\b[a-z])/g, function(x) {
            return x.toUpperCase();
        });
        $('#goal_category').val(category)
        $('#goal_target_text').val(formatNumber(goal_target))
        $('#mdl_input_goal').modal('show');
        $('#goal_actual').val('');
        dt_det_goal(goal_id, periode);

    }

    function dt_det_goal(goal_id, periode) {
        var table = $('#tbl_det_goal').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                "url": "<?= base_url(); ?>bsc_so/get_dt_goal_h",
                "data": {
                    periode: periode,
                    goal_id: goal_id,
                }
            },
            "columns": [{
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "employee_name",
                    "className": "text-nowrap"
                },
                {
                    "data": "actual_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "resume_h",
                    "className": "text-nowrap"
                },
                {
                    "data": "lampiran_h",
                    "render": function(data, type, row, meta) {
                        if (row['lampiran_h'] != '' && row['lampiran_h'] != null) {
                            return `<a href="<?= base_url() ?>uploads/so/${row['lampiran_h']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/so/${row['lampiran_h']}" data-src="<?= base_url() ?>uploads/so/${row['lampiran_h']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "link_h",
                    "render": function(data, type, row, meta) {
                        if (row['link_h'] != '' && row['link_h'] != null) {
                            return `<a href="${row['link_h']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "created_at",
                    "className": "text-nowrap"
                },
            ],
        });
    }

    function save_actual_goal() {
        goal_id = $('#goal_id').val()
        goal_category = $('#goal_category').val()
        goal_perspektive = $('#goal_perspektive').val()
        goal_sub = $('#goal_sub').val()
        goal_id_company = $('#goal_id_company').val()

        goal_resume = $('#goal_resume').val();
        goal_target = $('#goal_target').val();

        goal_actual = $('#goal_actual').val();
        goal_acv = parseFloat((parseInt(goal_actual) / parseInt(goal_target)) * 100).toFixed();
        console.info(goal_target);
        console.info(goal_actual);

        console.info(goal_acv);
        goal_periode = $('#goal_periode').val();
        goal_link = $('#goal_link').val();

        goal_file = document.getElementById('goal_file').files;

        if (!goal_id) {
            error_alert("Ketercapaian Kosong, silahkan refresh dahulu!");
            $('#goal_id').focus();
        } else if (goal_resume == '') {
            error_alert("Resume tidak boleh kosong!");
            $('#goal_resume').focus();
        } else if (goal_actual == '') {
            error_alert("Actual tidak boleh kosong!");
            $('#goal_actual').focus();
        } else if (document.getElementById("goal_file").files.length == 0 && so_link == '') {
            error_alert("Bukti File/Link salah satu harus di isi!");
        } else {
            $.confirm({
                title: 'Form Goal',
                content: 'Simpan Pencapaian Goal ?',
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


                                    if (document.getElementById("goal_file").files.length == 0) {
                                        const formData = new FormData();
                                        // The third parameter is required for server
                                        formData.append("goal_id", goal_id);
                                        formData.append("goal_perspektive", goal_perspektive);
                                        formData.append("goal_category", goal_category);
                                        formData.append("goal_sub", goal_sub);
                                        formData.append("goal_id_company", goal_id_company);

                                        formData.append("goal_target", goal_target);
                                        formData.append("goal_periode", goal_periode);

                                        formData.append("goal_resume", goal_resume);
                                        formData.append("goal_actual", goal_actual);

                                        formData.append("goal_link", goal_link);
                                        formData.append('goal_file', '');


                                        $.ajax({
                                            url: `<?= base_url('bsc_so/insert_goal') ?>`,
                                            type: 'POST',
                                            dataType: 'json',
                                            data: formData,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            beforeSend: function() {

                                            },
                                            success: function(response) {},
                                            error: function(xhr) {},
                                            complete: function() {},
                                        }).done(function(response) {
                                            dt_det_goal(goal_id, periode);
                                            $('#tbl_goal').DataTable().ajax.reload();
                                            $('#tbl_goal_h').DataTable().ajax.reload();
                                            if (response.update == true) {
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
                                    } else {
                                        // Dapatkan elemen input file
                                        const fileInput = document.getElementById('goal_file');

                                        // Dapatkan file yang dipilih langsung dari elemen input file
                                        const file = fileInput.files[0];
                                        new Compressor(file, {
                                            quality: 0.6,

                                            // The compression process is asynchronous,
                                            // which means you have to access the `result` in the `success` hook function.
                                            success(result) {
                                                console.log(result);
                                                const formData = new FormData();
                                                // The third parameter is required for server

                                                formData.append("goal_id", goal_id);
                                                formData.append("goal_perspektive", goal_perspektive);
                                                formData.append("goal_category", goal_category);
                                                formData.append("goal_sub", goal_sub);
                                                formData.append("goal_id_company", goal_id_company);

                                                formData.append("goal_target", goal_target);
                                                formData.append("goal_periode", goal_periode);

                                                formData.append("goal_resume", goal_resume);
                                                formData.append("goal_actual", goal_actual);

                                                formData.append("goal_link", goal_link);
                                                formData.append('goal_file', result, result.name);

                                                $.ajax({
                                                    url: `<?= base_url('bsc_so/insert_goal') ?>`,
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: formData,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    beforeSend: function() {

                                                    },
                                                    success: function(response) {},
                                                    error: function(xhr) {},
                                                    complete: function() {},
                                                }).done(function(response) {
                                                    dt_det_goal(goal_id, periode);
                                                    $('#tbl_goal').DataTable().ajax.reload();
                                                    $('#tbl_goal_h').DataTable().ajax.reload();
                                                    if (response.update == true) {
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
                                            },
                                            error(err) {
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: err.message,
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            },
                                        });
                                    }

                                    $('#goal_resume').val('');
                                    $('#goal_actual').val('');
                                    $('#goal_link').val('');
                                    $('#goal_file').val('');

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