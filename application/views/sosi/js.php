<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/compressorjs/dist/compressor.min.js"></script>

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

        function hideSearchInputs(columns) {
            for (i = 0; i < columns.length; i++) {
                if (columns[i]) {
                    $(".filters th:eq(" + i + ")").show();
                } else {
                    $(".filters th:eq(" + i + ")").hide();
                }
            }
        }


        // $('#dt_sosi thead tr').clone(true).addClass('filters').appendTo('#dt_sosi thead');
        var table = $('#dt_sosi').DataTable({});
        table.on("responsive-resize", function(e, datatable, columns) {
            hideSearchInputs(columns);
        });

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#titlecalendar').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dt_sosi(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            dt_search(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }

        $('.range').daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: 'YYYY-MM-DD'
            },
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


    function slim(selectId, placeholderText) {
        new SlimSelect({
            select: selectId,
            settings: {
                placeholderText: placeholderText,
            }
        });
    }

    get_strategi_objektif();

    function get_strategi_objektif() {
        let user_id = '<?= $this->session->userdata('user_id'); ?>'
        let periode = '<?= date("Y-m"); ?>'
        $.ajax({
            url: '<?= base_url() ?>sosi/get_strategi_objektif',
            type: 'POST',
            dataType: 'json',
            data: {
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
                objektif_list = '';
                $.each(response, function(index, value) {
                    let badge_color = '';
                    if (parseInt(value['group']) == 1) {
                        badge_color = 'bg-light-blue text-dark'
                    } else if (parseInt(value['group']) == 2) {
                        badge_color = 'bg-light-orange text-dark'
                    } else if (parseInt(value['group']) == 3) {
                        badge_color = 'bg-light-pink text-dark'
                    } else if (parseInt(value['group']) == 4) {
                        badge_color = 'bg-light-teal text-dark'
                    } else {
                        badge_color = 'bg-light-purple text-dark'
                    }
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
                    objektif_list += `<tr>
                                        <td onclick="modal_strategi_inisiatif('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:20%;">
                                            <span class="badge ${badge_color}">${value['strategi']}</span>
                                        </td>
                                        <td onclick="modal_strategi_inisiatif('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                                            <p class="small">${value['objektif']}</p>
                                        </td>
                                        <td onclick="modal_strategi_inisiatif('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                                            <p class="small text-center">${value['jml_o']}</p>
                                        </td>
                                        <td onclick="modal_strategi_inisiatif('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                                            <p class="small text-center">${value['ach_o']}</p>
                                        </td>
                                        <td onclick="modal_strategi_inisiatif('${value['id']}')" style="vertical-align:middle;cursor:pointer;width:80%;">
                                            <span class="small text-center badge ${badge_color_persen}">${value['persen']}%</span>
                                        </td>
                                    </tr>`;
                });
                $("#tbody_strategi_objektif").empty().append(objektif_list);
                $('#dt_strategi_objektif').DataTable();
            }
        }).fail(function(jqXhr, textStatus) {

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



    function hideSearchInputs(columns) {
        for (i = 0; i < columns.length; i++) {
            if (columns[i]) {
                $(".filters th:eq(" + i + ")").show();
            } else {
                $(".filters th:eq(" + i + ")").hide();
            }
        }
    }



    function dt_sosi(start, end) {
        var table = $('#dt_sosi').DataTable({
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
                "url": "<?= base_url(); ?>sosi/dt_sosi",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "week",
                    "className": "text-nowrap"
                },
                {
                    "data": "created_at",
                    "className": "text-nowrap"
                },
                {
                    "data": "employee_name",
                    "className": "text-nowrap"
                },
                {
                    "data": "objektif",
                    "width": "20%"
                },
                {
                    "data": "inisiatif",
                    "width": "20%"
                },
                {
                    "data": "task",
                    "width": "20%"
                },
                {
                    "data": "ketercapaian",
                },
                {
                    "data": "target",
                    "width": "5%"
                },
                {
                    "data": "actual",
                    "width": "5%"
                },
                {
                    "data": "status",
                },
                {
                    "data": "resume",
                },
                {
                    "data": "file",
                    "render": function(data, type, row, meta) {
                        if (row['file'] != '') {
                            return `<a href="<?= base_url() ?>uploads/sosi/${row['file']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/sosi/${row['file']}" data-src="<?= base_url() ?>uploads/sosi/${row['file']}" width="30" height="30" loading="lazy">
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
            ],
        });
    }

    function dt_detail_ketercapaian(id_ketercapaian) {
        var table = $('#dt_detail_ketercapaian').DataTable({
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
                "url": "<?= base_url(); ?>sosi/dt_detail_ketercapaian",
                "data": {
                    id_ketercapaian: id_ketercapaian,
                }
            },
            "columns": [{
                    "data": "periode",
                    "className": "text-nowrap"
                },
                {
                    "data": "week",
                    "className": "text-nowrap"
                },
                {
                    "data": "employee_name",
                    "className": "text-nowrap"
                },
                {
                    "data": "ketercapaian",
                    "className": "text-nowrap"
                },
                {
                    "data": "status",
                    "className": "text-nowrap"
                },
                {
                    "data": "actual",
                    "className": "text-nowrap"
                },
                {
                    "data": "resume",
                    "className": "text-nowrap"
                },
                {
                    "data": "file",
                    "render": function(data, type, row, meta) {
                        if (row['file'] != '') {
                            return `<a href="<?= base_url() ?>uploads/sosi/${row['file']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/sosi/${row['file']}" data-src="<?= base_url() ?>uploads/sosi/${row['file']}" width="30" height="30" loading="lazy">
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

    let searchNama = new SlimSelect({
        select: '#search-nama',
        settings: {
            placeholderText: 'Nama',
        }
    });
    let searchPeriode = new SlimSelect({
        select: '#search-periode',
        settings: {
            placeholderText: 'Periode',
        }
    });
    let searchWeek = new SlimSelect({
        select: '#search-week',
        settings: {
            placeholderText: 'week',
        }
    });
    let searchObjektif = new SlimSelect({
        select: '#search-objektif',
        settings: {
            placeholderText: 'Objektif',
        }
    });
    let searchInisiatif = new SlimSelect({
        select: '#search-inisiatif',
        settings: {
            placeholderText: 'Inisiatif',
        }
    });
    let searchTask = new SlimSelect({
        select: '#search-task',
        settings: {
            placeholderText: 'Task',
        }
    });

    function dt_search(start, end) {
        table = $('#dt_sosi').DataTable();
        $.ajax({
            url: '<?= base_url(); ?>sosi/dt_sosi',
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
            },
            beforeSend: function() {
                searchPeriode.setData();
                searchWeek.setData();
                searchNama.setData();
                searchObjektif.setData();
                searchInisiatif.setData();
                searchTask.setData();
            },
            success: function(response) {
                // ---------------------------------------------------------------------------------------
                array_periode = [];
                array_week = [];
                array_employee_name = [];
                array_objektif = [];
                array_inisiatif = [];
                array_task = [];
                for (let index = 0; index < response.data.length; index++) {
                    if (array_periode.indexOf(response.data[index].periode) === -1) {
                        array_periode.push(response.data[index].periode);
                    }
                    if (array_week.indexOf(response.data[index].week) === -1) {
                        array_week.push(response.data[index].week);
                    }
                    if (array_employee_name.indexOf(response.data[index].employee_name) === -1) {
                        array_employee_name.push(response.data[index].employee_name);
                    }
                    if (array_objektif.indexOf(response.data[index].objektif) === -1) {
                        array_objektif.push(response.data[index].objektif);
                    }
                    if (array_inisiatif.indexOf(response.data[index].inisiatif) === -1) {
                        array_inisiatif.push(response.data[index].inisiatif);
                    }
                    if (array_task.indexOf(response.data[index].task) === -1) {
                        array_task.push(response.data[index].task);
                    }
                }
                // ------
                itemPeriode = [];
                for (let index = 0; index < array_periode.length; index++) {
                    itemPeriode.push({
                        text: array_periode[index],
                        value: array_periode[index]
                    });
                }
                searchPeriode.setData(itemPeriode);

                $('#search-periode').on('change', function() {
                    rangePeriode = searchPeriode.getSelected().toString().replaceAll(",", "|");;
                    table.column(0).search(rangePeriode, true, false).draw();
                });
                // ------
                itemWeek = [];
                for (let index = 0; index < array_week.length; index++) {
                    itemWeek.push({
                        text: array_week[index],
                        value: array_week[index]
                    });
                }
                searchWeek.setData(itemWeek);

                $('#search-Week').on('change', function() {
                    rangeWeek = searchWeek.getSelected().toString().replaceAll(",", "|");;
                    table.column(1).search(rangeWeek, true, false).draw();
                });
                // ------
                itemEmployeArr = [];
                for (let index = 0; index < array_employee_name.length; index++) {
                    itemEmployeArr.push({
                        text: array_employee_name[index],
                        value: array_employee_name[index]
                    });
                }
                searchNama.setData(itemEmployeArr);

                $('#search-nama').on('change', function() {
                    rangeNama = searchNama.getSelected().toString().replaceAll(",", "|");
                    table.column(3).search(rangeNama, true, false).draw();
                });
                // ------
                itemObjektif = [];
                for (let index = 0; index < array_objektif.length; index++) {
                    itemObjektif.push({
                        text: array_objektif[index],
                        value: array_objektif[index]
                    });
                }
                searchObjektif.setData(itemObjektif);

                $('#search-objektif').on('change', function() {
                    rangeObjektif = searchObjektif.getSelected().toString().replaceAll(",", "|");
                    table.column(4).search(rangeObjektif, true, false).draw();
                });

                // ------
                itemInisiatif = [];
                for (let index = 0; index < array_inisiatif.length; index++) {
                    itemInisiatif.push({
                        text: array_inisiatif[index],
                        value: array_inisiatif[index]
                    });
                }
                searchInisiatif.setData(itemInisiatif);

                $('#search-inisiatif').on('change', function() {
                    rangeInisiatif = searchInisiatif.getSelected().toString().replaceAll(",", "|");
                    table.column(5).search(rangeInisiatif, true, false).draw();
                });
                // ------
                itemTask = [];
                for (let index = 0; index < array_task.length; index++) {
                    itemTask.push({
                        text: array_task[index],
                        value: array_task[index]
                    });
                }
                searchTask.setData(itemTask);
                $('#search-task').on('change', function() {
                    rangeTask = searchTask.getSelected().toString().replaceAll(",", "|");
                    table.column(6).search(rangeTask, true, false).draw();
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
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