<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/compressorjs/dist/compressor.min.js"></script>

<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.umd.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.min.css" rel="stylesheet">

<!-- Memuat script Dropzone.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script>
    $(document).ready(function() {

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

        dt_all_task('<?php echo date('Y-m') ?>');

        $("#periode").datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,
        });

        $("#periode_2").datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,
        });

        $("#periode").change(function() {
            periode = $("#periode").val()
            dt_all_task(periode);
        });

        $("#periode_2").change(function() {
            periode = $("#periode_2").val();
            frekuensi = $("#frekuensi").val();
            dt_task(periode, frekuensi);
        });

        $("#frekuensi").change(function() {
            periode = $("#periode_2").val();
            frekuensi = $("#frekuensi").val();
            dt_task(periode, frekuensi);
        });


        $('#btn_tasklist').click(function() {
            $('#modal_tasklist').modal('show');
            dt_task('<?php echo date('Y-m') ?>','All');
        });

        $('#tbl_task').on('click', '.update_tasklist', function() {
            id = $(this).data('id');
            periode = $(this).data('periode');
            target = $(this).data('target');
            strategy = $(this).data('strategy');

            $('#task_id_task').val(id);
            $('#task_periode').val(periode);
            $('#task_target').val(target);
            $('#task_target_val').val(target);
            $('#ketercapaian_text').text(strategy);

            $('#modal_input_tasklist').modal('show');
            data_tasklist_item_history(periode, id);
        });
    });

    var rupiah = document.getElementById("task_actual");
    rupiah.addEventListener("keyup", function(e) {
  // tambahkan 'Rp.' pada saat form di ketik
  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
      rupiah.value = formatRupiah(this.value, "Rp. ");
  });

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

    function dt_all_task(periode) {
        var table = $('#tbl_all_task').DataTable({
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
                "url": "<?= base_url(); ?>bsc_task/data_all_tasklist",
                "data": {
                    periode: periode,
                }
            },
            "columns": [{
                "data": "periode",
                "className": "text-nowrap"
            },
            {
                "data": "unit_bisnis",
                "className": "text-nowrap",
                "render": function (data, type, row) {
                    if (data == 'RSP') {
                        color = 'bg-light-red text-dark';
                    } else if (data == 'BT') {
                        color = 'bg-light-yellow text-dark';
                    } else {
                        color = 'bg-light-blue text-dark';
                    }

                    if (row['department'] == 'Operasional') {
                        color_dep = 'bg-light-pink text-dark';
                    } else if (row['department'] == 'Project') {
                        color_dep = 'bg-light-orange text-dark';
                    } else if (row['department'] == 'Marketing') {
                        color_dep = 'bg-light-green text-dark';
                    } else {
                        color_dep = 'bg-light-blue text-dark';
                    }

                    return `<span class="badge ${color}">${data}</span> <span class="badge ${color_dep}">${row['department']}</span>`
                }
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
                "data": "so",
                "className": "text-nowrap"
            },
            {
                "data": "si",
                "className": "text-nowrap"
            },
            {
                "data": "strategy",
                "className": "text-nowrap"
            },
            {
                "data": "target",
                "className": "text-nowrap",
                "render": function (data) {
                    return formatNumber2(data);
                }
            },
            {
                "data": "actual",
                "className": "text-nowrap",
                "render": function (data) {
                    return formatNumber2(data);
                }
            },
            {
                "data": "deviasi",
                "className": "text-nowrap",
                "render": function (data) {
                    return formatNumber2(data);
                }
            },
            {
                "data": "achieve",
                "className": "text-nowrap",
                "render": function (data) {
                    if (data < 60) {
                        color = "bg-red";
                    } else if (data > 59 && data < 76) {
                        color = "bg-yellow";
                    } else {
                        color = "bg-green"
                    }

                    return `<span class="badge ${color}">${data} %</span>`
                }
            },
            {
                "data": "lampiran",
                "render": function(data, type, row, meta) {
                    if (row['lampiran'] != '') {
                        lampiran = `<a href="<?= base_url(); ?>uploads/tasklist/${row['lampiran']}" data-fancybox data-caption="Single image">
                        <img src="<?= base_url(); ?>uploads/tasklist/${row['lampiran']}" data-src="<?= base_url(); ?>uploads/tasklist/${row['lampiran']}" width="30" height="30" loading="lazy">
                        </a>`
                    } else {
                        lampiran = ''
                    }

                    if (row['link'] != '') {
                        link = `<a href="${row['link']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
                    } else {
                        link = ''
                    }

                    return lampiran + link;
                }
            },
            {
                "data": "deviasi",
                "className": "text-nowrap"
            },
            {
                "data": "created_by",
                "className": "text-nowrap"
            },
            {
                "data": "created_at",
                "className": "text-nowrap"
            },
            ],
});
}

function dt_task(periode, frekuensi) {
    var table = $('#tbl_task').DataTable({
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
            "url": "<?= base_url(); ?>bsc_task/data_tasklist",
            "data": {
                periode: periode,
                frekuensi: frekuensi,
            }
        },
        "columns": [{
            "data": "periode",
            "className": "text-nowrap"
        },
        {
            "data": "unit_bisnis",
            "className": "text-nowrap",
            "render": function (data, type, row) {
                if (data == 'RSP') {
                    color = 'bg-light-red text-dark';
                } else if (data == 'BT') {
                    color = 'bg-light-yellow text-dark';
                } else {
                    color = 'bg-light-blue text-dark';
                }

                if (row['department'] == 'Operasional') {
                    color_dep = 'bg-light-pink text-dark';
                } else if (row['department'] == 'Project') {
                    color_dep = 'bg-light-orange text-dark';
                } else if (row['department'] == 'Marketing') {
                    color_dep = 'bg-light-green text-dark';
                } else {
                    color_dep = 'bg-light-blue text-dark';
                }

                return `<span class="badge ${color}">${data}</span> <span class="badge ${color_dep}">${row['department']}</span>`
            }
        },
        {
            "data": "so",
            "className": "text-nowrap"
        },
        {
            "data": "si",
            "className": "text-nowrap"
        },
        {
            "data": "tasklist",
            "className": "text-nowrap",
            "render": function (data, type, row) {
                return `<span class="badge bg-primary update_tasklist" data-id="${row['id']}" data-periode="${row['periode']}" data-target="${row['target']}" data-strategy="${row['tasklist']}" style="vertical-align:middle;cursor:pointer;">${data}</span>`
            }
        },
        {
            "data": "jabatan",
            "className": "text-nowrap"
        },
        {
            "data": "frekuensi",
            "className": "text-nowrap"
        },
        {
            "data": "target",
            "className": "text-nowrap"
        },
        {
            "data": "actual",
            "className": "text-nowrap",
            "render": function (data) {
                return formatNumber2(data);
            }
        },
        ],
    });
}

function data_tasklist_item_history(periode, id) {
    var table = $('#tbl_task_item_history').DataTable({
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
            "url": "<?= base_url(); ?>bsc_task/data_tasklist_item_history",
            "data": {
                periode: periode,
                id: id,
            }
        },
        "columns": [{
            "data": "periode",
            "className": "text-nowrap"
        },               
        {
            "data": "created_by",
            "className": "text-nowrap"
        },                
        {
            "data": "status",
            "className": "text-nowrap",
            "render": function (data) {
                if (data == "Berhasil") {
                    return `<span class="badge bg-green">${data}</span>`;
                } else {
                    return `<span class="badge bg-red">${data}</span>`;
                }
            }
        },
        {
            "data": "actual",
            "className": "text-nowrap",
            "render": function (data) {
                return formatNumber2(data);
            }
        },
        {
            "data": "resume",
            "className": "text-nowrap"
        },
        {
            "data": "lampiran",
            "render": function(data, type, row, meta) {
                if (row['lampiran'] != '') {
                    return `<a href="<?= base_url(); ?>uploads/tasklist/${row['lampiran']}" data-fancybox data-caption="Single image">
                    <img src="<?= base_url(); ?>uploads/tasklist/${row['lampiran']}" data-src="<?= base_url(); ?>uploads/tasklist/${row['lampiran']}" width="30" height="30" loading="lazy">
                    </a>`
                } else {
                    return '-'
                }
            }
        },
        {
            "data": "link",
            "render": function(data, type, row, meta) {
                if (row['link'] != '') {
                    return `<a href="${row['link']}" target="_blank" class="badge bg-light-blue"><i class="bi bi-box-arrow-up-right"></i></a>`
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

function save_actual_task() {
    task_id_task = $('#task_id_task').val()
    task_category = $('#task_category').val()

    task_status = $('input[name="task_status"]:checked').val();
    task_resume = $('#task_resume').val();
    task_target = $('#task_target').val();

    task_actual = $('#task_actual').val();
    task_acv = parseFloat((parseInt(task_actual) / parseInt(task_target) ) *  100).toFixed() ;
    console.info(task_target);
    console.info(task_actual);

    console.info(task_acv);
    periode = $('#task_periode').val();
    task_link = $('#task_link').val();

    task_file = document.getElementById('task_file').files;

    if (!task_id_task) {
        error_alert("Ketercapaian Kosong, silahkan refresh dahulu!");
        $('#task_id_task').focus();
    } else if (task_status == '') {
        error_alert("Status tidak boleh kosong!");
        $('#task_status').focus();
    } else if (task_resume == '') {
        error_alert("Resume tidak boleh kosong!");
        $('#task_resume').focus();
    } else if (task_actual == '') {
        error_alert("Actual tidak boleh kosong!");
        $('#task_actual').focus();
    } else if (document.getElementById("task_file").files.length == 0 && task_link == '') {
        error_alert("Bukti File/Link salah satu harus di isi!");
    } else {
        $.confirm({
            title: 'Form Tasklist',
            content: 'Simpan Pencapaian Tasklist ?',
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


                                if (document.getElementById("task_file").files.length == 0) {
                                    const formData = new FormData();
                                        // The third parameter is required for server
                                    formData.append("task_id_task", task_id_task);

                                    formData.append("task_status", task_status);
                                    formData.append("task_resume", task_resume);
                                    formData.append("task_target", task_target);
                                    formData.append("task_actual", task_actual);
                                    formData.append("task_acv", task_acv);
                                    formData.append("periode", periode);

                                    formData.append("task_link", task_link);
                                    formData.append('task_file', '');


                                    $.ajax({
                                        url: `<?php echo base_url() ?>bsc_task/insert_task`,
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
                                        $('#tbl_task').DataTable().ajax.reload();
                                        $('#tbl_task_item_history').DataTable().ajax.reload();
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
                                    const fileInput = document.getElementById('task_file');

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
                                            formData.append("task_id_task", task_id_task);

                                            formData.append("task_status", task_status);
                                            formData.append("task_resume", task_resume);
                                            formData.append("task_target", task_target);
                                            formData.append("task_actual", task_actual);
                                            formData.append("task_acv", task_acv);
                                            formData.append("periode", periode);

                                            formData.append("task_link", task_link);
                                            formData.append('task_file', result, result.name);


                                            $.ajax({
                                                url: `<?php echo base_url() ?>bsc_task/insert_task`,
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
                                                $('#tbl_task').DataTable().ajax.reload();
                                                $('#tbl_task_item_history').DataTable().ajax.reload();
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

$('#task_resume').val('');
$('#task_actual').val('');
$('#task_link').val('');
$('#task_file').val('');

},

});
}
},
cancel: function() {},
}
});
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



function modal_strategi_inisiatif(id_objektif) {
    $('#modal_strategi_inisiatif').modal('show');
    get_strategi_inisiatif(id_objektif);
}

function get_strategi_inisiatif(id_objektif) {
    let user_id = '<?= $this->session->userdata('user_id'); ?>'
    let periode = '<?= date("Y-m"); ?>'
    $.ajax({
        url: '<?= base_url() ?>sosi/get_strategi_inisiatif',
        type: 'POST',
        data: {
            user_id: user_id,
            id_objektif: id_objektif,
            periode: periode
        },
        dataType: 'json',
        beforeSend: function() {

        },
        success: function(response) {},
        error: function(xhr) {},
        complete: function() {},
    }).done(function(response) {
        if (response.length > 0) {
            inisiatif_list = '';
            badge_index_inisiatif = 0;
            let badge_color_inisiatif = ['bg-light-orange text-dark', 'bg-light-blue text-dark', 'bg-light-pink text-dark', 'bg-light-teal text-dark', 'bg-light-purple text-dark'];
            $.each(response, function(index, value) {
                let badge_color_persen = '';
                if (parseInt(value['persen']) < 65) {
                    badge_color_persen = 'bg-red text-white'
                } else if (parseInt(value['persen']) >= 65 && parseInt(value['persen']) < 75) {
                    badge_color_persen = 'bg-orange text-white'
                } else if (parseInt(value['persen']) >= 75) {
                    badge_color_persen = 'bg-green text-white'
                } else {
                    badge_color_persen = 'bg-purple text-white'
                }
                inisiatif_list += `<tr>
                <td onclick="modal_strategi_task('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                <span class="badge ${badge_color_inisiatif[badge_index_inisiatif]}">${value['inisiatif']}</span>
                </td>
                <td onclick="modal_strategi_task('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                <p>${value['task']}</p>
                </td>
                <td onclick="modal_strategi_task('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                <p>${value['actual']}</p>
                </td>
                <td onclick="modal_strategi_task('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                <span class="small text-center badge ${badge_color_persen}">${value['persen']}%</span>
                </td>
                </tr>`;
                badge_index_inisiatif++;
                if (badge_index_inisiatif == 5) {
                    badge_index_inisiatif = 0;
                }
            });
            $("#tbody_strategi_inisiatif").empty().append(inisiatif_list);
            $("#dt_strategi_inisiatif").DataTable();
        }
    }).fail(function(jqXhr, textStatus) {

    });
}

function modal_strategi_task(id_inisiatif) {
    $('#modal_strategi_task').modal('show');
    get_strategi_task(id_inisiatif);
}


function get_strategi_task(id_inisiatif) {
    let user_id = '<?= $this->session->userdata('user_id'); ?>'
    let periode = '<?= date("Y-m"); ?>'
    $.ajax({
        url: '<?= base_url() ?>sosi/get_strategi_task',
        type: 'POST',
        dataType: 'json',
        data: {
            id_inisiatif: id_inisiatif,
            periode: periode,
            user_id: user_id
        },
        beforeSend: function() {

        },
        success: function(response) {},
        error: function(xhr) {},
        complete: function() {},
    }).done(function(response) {
        if (response.length > 0) {
            ketercapaian_list = '';
            badge_index_task = 0;
            let badge_color_task = ['bg-light-orange text-orange', 'bg-light-blue text-blue', 'bg-light-pink text-pink', 'bg-light-teal text-teal', 'bg-light-purple text-purple'];
            $.each(response, function(index, value) {
                let badge_color_persen = '';
                if (parseInt(value['persen']) < 65) {
                    badge_color_persen = 'bg-red text-white'
                } else if (parseInt(value['persen']) >= 65 && parseInt(value['persen']) < 75) {
                    badge_color_persen = 'bg-orange text-white'
                } else if (parseInt(value['persen']) >= 75) {
                    badge_color_persen = 'bg-green text-white'
                } else {
                    badge_color_persen = 'bg-purple text-white'
                }
                ketercapaian_list += `<tr>
                <td onclick="modal_strategi_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                <span class="badge ${badge_color_task[badge_index_task]}">${value['task']}</span>    
                </td>
                <td onclick="modal_strategi_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                <p>${value['target']}</p>
                </td>
                <td onclick="modal_strategi_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                <p>${value['actual']}</p>
                </td>
                <td onclick="modal_strategi_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                <span class="small text-center badge ${badge_color_persen}">${value['persen']}%</span>
                </td>
                </tr>`;
                badge_index_task++;
                if (badge_index_task == 5) {
                    badge_index_task = 0;
                }
            });
            $("#tbody_strategi_task").empty().append(ketercapaian_list);
            $("#dt_strategi_task").DataTable();
        }
    }).fail(function(jqXhr, textStatus) {

    });
}


function modal_strategi_ketercapaian(id_task) {
    $('#modal_strategi_ketercapaian').modal('show');
    get_strategi_ketercapaian(id_task);
}


function get_strategi_ketercapaian(id_task) {
    let user_id = '<?= $this->session->userdata('user_id'); ?>';
    let periode = '<?= date("Y-m"); ?>';
    $.ajax({
        url: '<?= base_url() ?>sosi/get_strategi_ketercapaian',
        type: 'POST',
        dataType: 'json',
        data: {
            id_task: id_task,
            user_id: user_id,
            periode: periode
        },
        beforeSend: function() {

        },
        success: function(response) {},
        error: function(xhr) {},
        complete: function() {},
    }).done(function(response) {
        if (response.length > 0) {
            ketercapaian_list = '';
            no = 1;
            badge_index_ketercapaian = 0;
            let badge_color_ketercapaian = ['bg-light-orange text-orange', 'bg-light-blue text-blue', 'bg-light-pink text-pink', 'bg-light-teal text-teal', 'bg-light-purple text-purple'];
            $.each(response, function(index, value) {
                let badge_color_persen = '';
                if (parseInt(value['persen']) < 65) {
                    badge_color_persen = 'bg-red text-white'
                } else if (parseInt(value['persen']) >= 65 && parseInt(value['persen']) < 75) {
                    badge_color_persen = 'bg-orange text-white'
                } else if (parseInt(value['persen']) >= 75) {
                    badge_color_persen = 'bg-green text-white'
                } else {
                    badge_color_persen = 'bg-purple text-white'
                }
                ketercapaian_list += `
                <tr>
                <td onclick="modal_input_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                <span class="badge ${badge_color_ketercapaian[badge_index_ketercapaian]}">${value['ketercapaian']}</span>     
                </td>
                <td onclick="modal_input_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                <p>${value['target']}</p>
                </td>
                <td onclick="modal_input_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                <p>${value['actual']}</p>
                </td>
                <td onclick="modal_input_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                <span class="small text-center badge ${badge_color_persen}">${value['persen']}%</span>
                </td>
                </tr>
                `;
                badge_index_ketercapaian++;
                if (badge_index_ketercapaian == 5) {
                    badge_index_ketercapaian = 0;
                }
                no++;
            });
            $("#tbody_strategi_ketercapaian").empty().append(ketercapaian_list);
            $("#dt_strategi_ketercapaian").DataTable();
        }
    }).fail(function(jqXhr, textStatus) {

    });
}

function modal_input_ketercapaian(id_ketercapaian) {
    $('#modal_input_ketercapaian').modal('show');
    get_input_ketercapaian(id_ketercapaian);
    dt_detail_ketercapaian(id_ketercapaian);
}


function get_input_ketercapaian(id_ketercapaian) {
    $.ajax({
        url: '<?= base_url() ?>sosi/get_detail_ketercapaian',
        type: 'POST',
        dataType: 'json',
        data: {
            id_ketercapaian: id_ketercapaian
        },
        beforeSend: function() {

        },
        success: function(response) {},
        error: function(xhr) {},
        complete: function() {},
    }).done(function(response) {
        if (response.length > 0) {
            $('#ketercapaian').val(response[0].id);
            $('#ketercapaian_text').text(response[0].ketercapaian);
                // ketercapaian_list = '';
                // no = 1;
                // $.each(response, function(index, value) {
                //     ketercapaian_list += `
                //                         <tr>
                //                             <td onclick="modal_input_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                //                                 <p>${value['ketercapaian']}</p>
                //                             </td>
                //                             <td onclick="modal_input_ketercapaian('${value['id']}')" style="vertical-align:middle;cursor:pointer;">
                //                                 <p>${value['target']}</p>
                //                             </td>
                //                         </tr>
                //                 `;
                //     no++;
                // });
                // $("#tbody_strategi_ketercapaian").empty().append(ketercapaian_list);
                // $("#dt_strategi_ketercapaian").DataTable();
        }
    }).fail(function(jqXhr, textStatus) {

    });
}

function save() {
    ketercapaian = $('#ketercapaian').val()
    status = $('input[name="status"]:checked').val();
    resume = $('#resume').val();
    actual = $('#actual').val();
    link = $('#link').val();
    file = document.getElementById('file').files;

    if (!ketercapaian) {
        error_alert("Ketercapaian Kosong, silahkan refresh dahulu!");
        $('#ketercapaian').focus();
    } else if (status == '') {
        error_alert("Status tidak boleh kosong!");
        $('#status').focus();
    } else if (resume == '') {
        error_alert("Resume tidak boleh kosong!");
        $('#resume').focus();
    } else if (actual == '') {
        error_alert("Actual tidak boleh kosong!");
        $('#actual').focus();
    } else if (document.getElementById("file").files.length == 0 && link == '') {
        error_alert("Bukti File/Link salah satu harus di isi!");
    } else {
        $.confirm({
            title: 'Form Strategi',
            content: 'Simpan Pencapaian ?',
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


                                if (document.getElementById("file").files.length == 0) {
                                    const formData = new FormData();
                                        // The third parameter is required for server
                                    formData.append("ketercapaian", ketercapaian);
                                    formData.append("status", status);
                                    formData.append("resume", resume);
                                    formData.append("actual", actual);
                                    formData.append("link", link);
                                    formData.append('file', '');


                                    $.ajax({
                                        url: `<?= base_url('sosi/save') ?>`,
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
                                        dt_detail_ketercapaian(ketercapaian)
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
                                    const fileInput = document.getElementById('file');

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
                                            formData.append("ketercapaian", ketercapaian);
                                            formData.append("status", status);
                                            formData.append("resume", resume);
                                            formData.append("actual", actual);
                                            formData.append("link", link);
                                            formData.append('file', result, result.name);


                                            $.ajax({
                                                url: `<?= base_url('sosi/save') ?>`,
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
                                                dt_detail_ketercapaian(ketercapaian)
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

$('#resume').val('');
$('#actual').val('');
$('#link').val('');
$('#file').val('');

},

});
}
},
cancel: function() {},
}
});
}
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

function formatNumber(num) {
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
    
</script>