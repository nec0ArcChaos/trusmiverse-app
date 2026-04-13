<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
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
        $('.key_list').keyup(function(e) {
            if (e.which == 13) { // Kode 13 adalah key code untuk tombol enter
                e.preventDefault(); // Mencegah form dari submit default
                tambah_list(); // Memanggil fungsi tambah_list
                return false;
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


        dt_assm('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');


        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_assm(start, end);

        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_assm(start, end);
        })

        

    });
    $('.progress-input').each(function() {
        var $input = $(this);
        var $range = $input.closest('.nilai').find('.progress-range'); // Find the corresponding range in the same group

        // When input number changes, update the range
        $input.on('input', function() {
            $range.val($input.val());
        });

        // When range changes, update the number input
        $range.on('input', function() {
            $input.val($range.val());
        });
    });

    var base_url = '<?= base_url('job_assessment/'); ?>';

    function dt_assm(start, end) {

        $('#dt_assm').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'Data Assessment ' + start,
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": base_url + "get_data",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [
                // {
                //     'data': 'user_id',

                // },
                {
                    'data': 'id_assessment',
                    'render': function(data, type, row) {
                        return `<span class="badge bg-success" style='cursor:pointer' onclick="lihat_detail('${data}','id')"><i class="bi bi-eyeglasses"></i> ${data}</span>`;
                    }
                },
                {
                    'data': 'nama',
                },
                {
                    'data': 'company',
                },
                {
                    'data': 'department_name',
                },
                {
                    'data': 'designation_name',
                },
                {
                    'data': 'role_from',
                    'render': function(data, type, row) {
                        return `<span class="badge bg-light-blue text-black">${row['role_from']}</span> > <span class="badge bg-light-yellow text-black">${row['role_to']}</span>`;
                    }
                },
                {
                    'data': 'hasil_psikotest',
                    'render': function(data, type, row) {
                        if (data == '-') {
                            return `<span class="badge bg-light-red text-black" style='cursor:pointer' onclick="psikotest('${row['id_assessment']}','${row['nama']}','${row['company']+' | '+row['department_name']}','${row['role_from']+' to '+row['role_to']}','${row['user_id']}')"><i class="bi bi-cursor-fill"></i> Proses</span>`;
                        } else {
                            return `<span class="badge bg-${row['warna_psikotest']}"> ${data}</span>`;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'hasil_panelis',
                    'render': function(data, type, row) {
                        if (data == '-') {
                            return `<span class="badge bg-light-red text-black" style='cursor:pointer' onclick="panelis('${row['id_assessment']}','${row['nama']}','${row['company']+' | '+row['department_name']}','${row['role_from']+' to '+row['role_to']}')"><i class="bi bi-cursor-fill"></i> Review</span>`;
                        } else {
                            return `<span class="badge bg-${row['warna_panelis']}"> ${data}</span>`;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'kesimpulan',
                    'className': 'text-center',
                    'render': function(data, type, row) {
                        if (row['hasil_psikotest'] != '-' && row['hasil_panelis'] != '-' && row['kesimpulan'] == '-') {
                            return `<span class="badge bg-light-red text-black" style='cursor:pointer' onclick="lihat_detail('${row['id_assessment']}','kesimpulan')"><i class="bi bi-cursor-fill"></i> Proses</span>`;
                        } else {
                            return `<span class="badge bg-${row['warna_kesimpulan']}"> ${data}</span>`;
                        }
                    }
                },

                {
                    'data': 'created_at',
                },
                {
                    'data': 'created_by',
                },


            ],
            // "createdRow": function(row, data, dataIndex) {
            //     // 
            // }
        });
    }

    function input() {

        $('#modal_input').modal('show');
        url = "<?= base_url('job_assessment/get_karyawan') ?>";
        $.getJSON(url, function(result) {
            res = '<option data-placeholder="true">-- Choose Employee --</option>';
            $.each(result, function(index, value) {
                if ([6, 7].includes(Number(value['user_role_id']))) {
                    res +=
                        `<option value="${value['user_id']}" >${value['nama_karyawan']} | ${value['designation_name']}| ${value['company']}</option>`;
                }
            })
            $("#karyawan").empty().html(res);
            slim_karyawan = new SlimSelect({
                select: "#karyawan",
                settings: {
                    allowDeselect: true
                }
            });
            res2 = '<option data-placeholder="true">-- Choose Employee --</option>';
            $.each(result, function(index, value) {
                if ([5, 4, 3, 2].includes(Number(value['user_role_id']))) {
                    res2 +=
                        `<option value="${value['user_id']}" >${value['nama_karyawan']} | ${value['designation_name']}| ${value['company']}</option>`;
                }
            })
            $("#panelis").empty().html(res2);
            slim_panelis = new SlimSelect({
                select: "#panelis",
                settings: {
                    allowDeselect: true
                }
            });
        });
    }

    var lastClickTime = 0;

    $('#form_input').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var karyawan = $(form).find('[name="karyawan"]').val();
        var due_date = $(form).find('[name="due_date"]').val();
        var poin_kompetensi = $(form).find("[name='poin_kompetensi[]']").val();
        var panelis = $(form).find("[name='panelis[]']").val();
        var currentTime = new Date().getTime();
        console.log(poin_kompetensi);
        if (currentTime - lastClickTime < 300) {
            alert('Anda menekan 2x tombol save, coba lagi');
            lastClickTime = currentTime; // Reset waktu klik terakhir setelah mendeteksi double click
            return; // Hentikan eksekusi lebih lanjut jika double click terdeteksi

        } else if (karyawan == '-- Choose Employee --' || karyawan == '') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Anda belum memilih karyawan!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (panelis.length = 0 || panelis == '-- Choose Employee --' || panelis == '') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Pilih Penelis minimal 1!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (poin_kompetensi.length = 0 || poin_kompetensi == '') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Poin kompetensi minimal 1 data!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (due_date == '') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Due date harus di isi!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah data tersebut benar?',
                buttons: {
                    confirm: function() {
                        var loadingDialog = $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Loading',
                            theme: 'material',
                            type: 'blue',
                            content: 'Please wait, processing...',
                            buttons: false, // Disable buttons
                            closeIcon: false, // Disable close icon
                        });
                        $.ajax({
                            type: "POST",
                            url: `${base_url}save`,
                            data: form.serialize(),
                            dataType: "json",
                            success: function(response) {
                                console.log(response);
                                for (var i = jum_list; i > 1; i--) {
                                    $('#row_list' + i).remove();
                                    jum_list--;
                                }
                                loadingDialog.close();
                                $(form).find('#karyawan').val('');
                                $(form).find('#panelis').val('');
                                $(form).find('[name="due_date"]').val('');
                                $(form).find("[name='poin_kompetensi[]']").val('');
                                $('#modal_input').modal('hide');
                                $("#dt_assm").DataTable().ajax.reload();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Success',
                                    theme: 'material',
                                    type: 'green',
                                    content: 'Data has been saved!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }
                        });
                    },
                    close: {
                        actions: function() {
                            // $('#modal_input').modal('hide');
                            // $("#dt-pk").DataTable().ajax.reload();
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
        }
    });

    function psikotest(id, nama, company, level, user_id) {
        var modal = $('#modal_psikotest');
        $(modal).find('[name="id_assessment"]').val(id);
        $(modal).find('[name="nama"]').val(nama);
        $(modal).find('[name="company"]').val(company);
        $(modal).find('[name="level"]').val(level);
        $(modal).modal('show');
        $.ajax({
            type: "POST",
            url: base_url + 'get_tiu_disc_mbti',
            data: {
                user_id: user_id
            },
            dataType: "json",
            success: function(response) {
                $(modal).find('[name="tiu"]').val(response.iq);
                $(modal).find('[name="disc"]').val(response.disc);
                $(modal).find('[name="mbti"]').val(response.mbti);
            }
        });
    }

    function list_panelis() {
        $('#modal_list_panelis').modal('show');
        $('#dt_list_panelis').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'Data Assessment ' + start,
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "GET",
                "url": base_url + "data_for_panelis",
            },
            "columns": [{
                    'data': 'id_assessment',
                    'render': function(data, type, row) {
                        return `<span class="badge bg-primary" style='cursor:pointer' onclick="update_panelis('${data}','${row['panelis_id']}')">${data}</span>`;
                    }
                },
                {
                    'data': 'nama',
                },
                {
                    'data': 'role_from',
                    'render': function(data, type, row) {
                        return `<span class="badge bg-light-blue text-black">${row['role_from']}</span> > <span class="badge bg-light-yellow text-black">${row['role_to']}</span>`;
                    }
                },
                {
                    'data': 'nama_panelis',
                },
                {
                    'data': 'status_poin',
                    'render': function(data, type, row) {
                        if (data == 'Submitted') {
                            return `<span class="badge bg-light-green text-black"><i class="bi bi-check2-all"></i> ${data}</span>`;

                        } else {
                            return `<span class="badge bg-light-yellow text-black"><i class="bi bi-hourglass-split"></i> ${data}</span>`;

                        }
                    }
                },


                {
                    'data': 'created_at',
                },
                {
                    'data': 'created_by',
                },


            ],
            // "createdRow": function(row, data, dataIndex) {
            //     // 
            // }
        });
    }

    $('#form_psikotest').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah data tersebut benar?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    $.ajax({
                        type: "POST",
                        url: `${base_url}update_psikotest`,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            $(form).trigger('reset');
                            $('#modal_psikotest').modal('hide');
                            $("#dt_assm").DataTable().ajax.reload();
                            loadingDialog.close();
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }
                    });
                },
                close: {
                    actions: function() {
                        loadingDialog.close();
                        // $('#modal_input').modal('hide');
                        // $("#dt-pk").DataTable().ajax.reload();
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });

    function panelis(id, nama, company, level) {
        var modal = $('#modal_panelis');
        $(modal).find('[name="id_assessment"]').val(id);
        $(modal).find('[name="nama"]').val(nama);
        $(modal).find('[name="company"]').val(company);
        $(modal).find('[name="level"]').val(level);
        $(modal).find('[name="id_assessment"]').val(id);
        $(modal).modal('show');
        get_data_panelis(id);
    }

    function get_data_panelis(id) {
        $.ajax({
            type: "POST",
            url: base_url + "get_data_panelis",
            data: {
                id_assessment: id
            },
            dataType: "json",
            success: function(result) {
                $('#panelis_review').empty().append(result);
                $('#dt_panelis').DataTable({
                    "searching": true,
                    "info": true,
                    "paging": true,
                    "destroy": true,
                    "dom": 'Bfrtip',
                    buttons: [{
                        title: 'Data Assessment ' + start,
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        footer: true
                    }],
                });
            }
        });
    }

    function update_panelis(id_assessment, panelis_id) {
        var modal = $('#modal_penilaian');
        $(modal).modal('show');
        $(modal).find('[name="id_assessment"]').val(id_assessment);
        $(modal).find('[name="panelis_id"]').val(panelis_id);
        $.ajax({
            type: "POST",
            url: base_url + "get_item_poin",
            data: {
                id_assessment: id_assessment,
                panelis_id: panelis_id
            },
            dataType: "json",
            success: function(response) {
                var list_poin = '';
                response.forEach((value, index) => {
                    list_poin += `
                    <div class="col-4 nilai">
                        <label class="form-label-custom required small" for="cfit">${value.poin_kompetensi}</label>
                        <div class="input-group border-custom">
                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                            <input type="number" name="nilai[]" class="form-control progress-input border-custom validasi_number" min="0" max="100" value="0" data-index="${index}" required>
                            <input type="hidden" name="id_poin[]" value="${value.id}">
                        </div>
                        <input type="range" class="form-range progress-range" min="0" max="100" value="0" step="5" data-index="${index}">
                    </div>
                    `;
                });
                $('#list_poin').empty().append(list_poin);

                $('.progress-input').on('input', function() {
                    var index = $(this).data('index');
                    $(`.progress-range[data-index="${index}"]`).val($(this).val()); // Update the corresponding range value
                });

                $('.progress-range').on('input', function() {
                    var index = $(this).data('index');
                    $(`.progress-input[data-index="${index}"]`).val($(this).val()); // Update the corresponding number value
                });
            }
        });
    }

    $('#form_panelis').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah data tersebut benar?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    $.ajax({
                        type: "POST",
                        url: `${base_url}update_panelis`,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            $('#modal_penilaian').modal('hide');
                            $("#dt_assm").DataTable().ajax.reload();
                            $("#dt_list_panelis").DataTable().ajax.reload();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }
                    });
                },
                close: {
                    actions: function() {
                        // $('#modal_input').modal('hide');
                        // $("#dt-pk").DataTable().ajax.reload();
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });

    $('#form_review_panelis').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah data tersebut benar?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    $.ajax({
                        type: "POST",
                        url: `${base_url}review_panelis`,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                            $('#modal_panelis').modal('hide');
                            $("#dt_assm").DataTable().ajax.reload();
                            loadingDialog.close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }
                    });
                },
                close: {
                    actions: function() {
                        // $('#modal_input').modal('hide');
                        // $("#dt-pk").DataTable().ajax.reload();
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });

    function lihat_detail(id, tipe) {
        $('#modal_detail').modal('show');
        $('#modal_detail').find('[name="id_assessment"]').val(id);
        if (tipe == 'id') { // dari kolom id klik
            $('#form_kesimpulan').hide();
        } else {
            $('#form_kesimpulan').show();
        }


        $.ajax({
            type: "GET",
            url: base_url + 'get_detail/' + id,
            dataType: "json",
            success: function(response) {
                $('#d_nama').text(response.detail.nama);
                $('#d_level').text(response.detail.role_from + ' to ' + response.detail.role_to);
                $('#hasil_psikotest').text('Hasil Psikotest : ' + response.detail.hasil_psikotest);
                $('#hasil_panelis').text('Hasil Panelis : ' + response.detail.hasil_panelis);
                $('#kesimpulan').text('Kesimpulan : ' + response.detail.kesimpulan);
                $('#d_due_date').text(response.detail.due_date);
                $('#d_actual_date').text(response.detail.actual_date);
                $('#d_created_at').text(response.detail.created_at);
                $('#d_created_by').text(response.detail.created_by);
                $('#d_avg_panelis').text('Avg Panelis : ' + response.detail.avg_panelis);
                $('#d_spesifikasi_teknis').text('Spesifikasi Teknis : ' + response.detail.spesifikasi_teknis);

                table_psikotest = `<tr>
            <td>Army Alpha : <b>${response.psikotest.army_alpha}</b></td>
            <td>CFIT : <b>${response.psikotest.cfit}</b></td>
            <td>IQ : <b>${response.psikotest.iq}</b></td>
            </tr>
            <tr>
            <td>TIU : <b>${response.psikotest.tiu}</b></td>
            <td>DISC : <b>${response.psikotest.disc}</b></td>
            <td>MBTI : <b>${response.psikotest.mbti}</b></td>
            </tr>`;
                $('#detail_hasil_psikotest').empty().append(table_psikotest);
                $('#detail_hasil_panelis').empty().append(response.panelis);
                $('#tabel_panelis').DataTable({
                    "searching": true,
                    "info": true,
                    "paging": true,
                    "destroy": true,
                    "dom": 'Bfrtip',
                    buttons: [{
                        title: 'Data Assessment ' + start,
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        footer: true
                    }],
                });
                // var kompetensi = response.panelis.kompetensi;
                // var columns = [{
                //         "data": "id_assessment",
                //         "render": function(data, type, row, meta) {
                //             return meta.row + 1;
                //         },
                //         'className': 'text-center'
                //     },
                //     {
                //         data: 'nama_panelis',
                //         title: 'Nama Panelis',
                //         render: function(data, type, row) {
                //             return `${data}`;
                //         }
                //     },
                //     {
                //         data: 'status_poin',
                //         title: 'Status',
                //         render: function(data, type, row) {
                //             if (data === 'Submitted') {
                //                 return `<span class="badge bg-light-green text-black"><i class="bi bi-check2-all"></i> ${data}</span>`;
                //             } else {
                //                 return `<span class="badge bg-light-yellow text-black"><i class="bi bi-hourglass-split"></i> ${data}</span>`;
                //             }
                //         }
                //     }
                // ];
                // // Generate columns dynamically for each poin_kompetensi
                // $.each(kompetensi, function(index, item) {
                //     columns.push({
                //         data: function(row) {
                //             return row.kompetensi && row.kompetensi[item] ? row.kompetensi[item] : '-';
                //         },
                //         title: item, // Use the kompetensi name as the column title
                //         className: 'text-center'
                //     });
                // });
                // // Add static columns for total_nilai and rata_rata
                // columns.push({
                //     data: 'total_nilai',
                //     title: 'Jumlah',
                //     className: 'text-center'
                // });
                // columns.push({
                //     data: 'rata_rata',
                //     title: 'Rata rata',
                //     className: 'text-center'
                // });
                // Inisialisasi DataTable dengan data baru
                // var table = $('#detail_hasil_panelis').DataTable({
                //     "searching": true,
                //     "info": true,
                //     "paging": true,
                //     "destroy": true,
                //     "dom": 'Bfrtip',
                //     stateSave: true,
                //     serverSide: false,
                //     orderCellsTop: true,
                //     data: Object.values(response.panelis.data), // Ensure the data matches your expected format
                //     columns: columns,
                //     buttons: [{
                //         title: 'Data Assessment ' + start,
                //         extend: 'excelHtml5',
                //         text: 'Export to Excel',
                //         footer: true
                //     }],
                // });


            }
        });
    }

    function table_detail_panelis(response) {



    }



    $('#form_kesimpulan').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah data tersebut benar?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    $.ajax({
                        type: "POST",
                        url: `${base_url}update_kesimpulan`,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                            $('#modal_detail').modal('hide');
                            $("#dt_assm").DataTable().ajax.reload();
                            loadingDialog.close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }
                    });
                },
                close: {
                    actions: function() {
                        // $('#modal_input').modal('hide');
                        // $("#dt-pk").DataTable().ajax.reload();
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });







    var jum_list = 1;

    function tambah_list() {
        jum_list++;
        $('#btn_hapus_list').attr('disabled', false);
        input = `<div class="row row_list" id="row_list${jum_list}">
    <div class="col"><div class="input-group border-custom mb-2">
                                <span class="input-group-text bi bi-card-checklist"></span>

                                <input type="text" class="form-control border-custom key_list" name="poin_kompetensi[]" id="poin_kompetensi${jum_list}"
                                    placeholder="Poin Kompetensi ${jum_list}"
                                    >
                                    
                                    </div></div></div>`;
        $('#tempat_list').append(input);

        setTimeout(() => {
            $(`#poin_kompetensi${jum_list}`).focus();
        }, 100);

    }

    function hapus_list() {
        if (jum_list == 1) {
            $('#btn_hapus_list').attr('disabled', true);
        } else {
            $('#btn_hapus_list').attr('disabled', false);
            $('#row_list' + jum_list).remove();
            jum_list--;
        }
    }




    $('.validasi_number').on('focus', function() {
        // Check if the value is 0, if yes, clear the input
        if ($(this).val() == '0') {
            $(this).val('');
        }
    });


    function handleClick() {
        var currentTime = new Date().getTime(); // Mendapatkan waktu saat ini
        var timeDiff = currentTime - lastClickTime; // Menghitung selisih waktu dari klik terakhir
        lastClickTime = currentTime; // Memperbarui waktu klik terakhir

        if (timeDiff < threshold) {
            return true; // Mengembalikan true jika terdeteksi double click
        } else {
            return false; // Mengembalikan false jika tidak terdeteksi double click
        }
    }
</script>