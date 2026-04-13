<!-- Datatable Button -->


<!-- NEWW -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>

<!-- belum verif -->


<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/compressorjs/dist/compressor.min.js"></script>

<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.umd.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.min.css" rel="stylesheet"> -->

<!-- Memuat script Dropzone.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {
        // datepicker month
        $("#periode").datepicker({
            format: "yyyy-mm",
            viewMode: "year",
            minViewMode: "months",
            autoclose: true,
            orientation: "bottom",
        });


        $('#periode').on('change', function() {
            $('input[name="period"]').attr('value', this.value)
        });
        //  end date picker month

        year = '<?= date('Y') ?>';
        month = '<?= date('m') ?>';
        $('#hide').hide();

        list_budget(year, month);
        $('#list_budget').on('click', function() {
            // $('#modal_add_budget').modal({
            //     backdrop: 'static',
            //     keyboard: false
            // });
            $('#modal_add_budget').modal("show");
        });

        

        $('#dt_budget').on('click', '.penambahan_biaya', function() {
            //dt_list_member.ajax.reload();
            id_biaya = $(this).data('id_biaya');
            sisa_budget = $(this).data('budget');
            bulan = $(this).data('bulan');
            tahun_budgets = $(this).data('tahun_nih');
            nama_text = $(this).data('nama_biaya');
            contact_user = $(this).data('no_hp');

            if (sisa_budget == null) {
                console.log(`Null yaa`);
                swal({
                    title: "Warning",
                    text: "\nBudget Unlimited, tidak bisa dilakukan penambahan budget\n",
                    icon: "warning",
                    timer: 2000,
                    buttons: false
                });
            } else {
                console.log(`Tidak Null`);
                $('#modal_add_penambahan').modal('show');
                $('#id_biaya_tam').val(id_biaya);
                //$('#text_nama_biaya').val(nama_biaya);
                document.getElementById("text_nama_biaya").innerHTML = nama_text;
                $('#bulan_tam').val(bulan);
                $('#tahun_tam').val(tahun_budgets);
                $('#nama_biaya_tam').val(nama_text);
                $('#sisa_budget').val(sisa_budget);
                $('#no_hp_user').val(contact_user);
                reload_table_penambahan();
            }



            //$('#modal_add_penambahan').modal({backdrop: 'static', keyboard: false});

        });

        $('#company_id').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            var selectedValue = $(this).val(); // Get the selected value
            // console.log('Selected value:', selectedValue);
            // Perform actions based on the new value
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>eaf/budget/data_budget_list",
                "data": {
                    company_id: selectedValue,
                },
                dataType: "JSON",
                success: function(response) {

                    bootstrap_otions = ``;
                    bootstrap_otions = '<option value="default" disabled selected>-- Pilih Biaya --</option>';
                    response.forEach((value, index) => {

                        // options.push({value: value.id_budget, text: value.budget});
                        // bootstrap_otions = `<option value="" selected disabled>-- Pilih Biaya --</option>`
                        bootstrap_otions += `<option value="${value.id_budget}|${value.budget}">${value.budget}</option>`

                    });

                    $('#nama_biaya').html(bootstrap_otions);
                    $('#nama_biaya').selectpicker({
                        noneSelectedText: '-- Pilih Biaya --'
                    });
                    // $('#nama_biaya').val('default');
                    // $('#nama_biaya').selectpicker('render');
                    $('#nama_biaya').selectpicker('refresh');
                    // $('#nama_biaya').setSelected('');
                    // $('#nama_biaya').val('');



                },
                error: function(err) {
                    console.error(err.responseText)
                },
                complete: function() {
                    // $('#nama_biaya').setSelected(value);
                }
            })
        });

        $('#list_tambah').on('click', function() {
            $('#modal_add_penambahan').modal('hide');
            $('#modal_penambahan').modal('show');
            id_biaya_tam = $('#id_biaya_tam').val();
            minggu_tam = $('#minggu_tam').val();
            bulan_tam = $('#bulan_tam').val();
            tahun_tam = $('#tahun_tam').val();
            nama_biaya_tam = $('#nama_biaya_tam').val();
            no_hp_tam = $('#no_hp_user').val();

            var x = document.getElementById("text_nama_biaya").innerHTML;
            document.getElementById("text_nama_biaya2").innerHTML = x;


            $('#id_biaya_tambah').val(id_biaya_tam);
            $('#minggu_tambah').val(minggu_tam);
            $('#bulan_tambah').val(bulan_tam);
            $('#tahun_tambah').val(tahun_tam);
            $('#nama_biaya_tambah').val(nama_biaya_tam);
            $('#no_hp_tambah').val(no_hp_tam);
            //$('#modal_penambahan').modal({backdrop: 'static', keyboard: false});
        });

        $('#save_budget').on('click', function() {
            company_id = $('#company_id');
            nama_biaya = $('#nama_biaya');
            nama_biaya_val = nama_biaya.val();
            minggu_biaya = $('#minggu_biaya');
            bulan_biaya = $('#bulan_biaya');
            tahun_budget = $('#tahun_budget');
            nominal_budget = $('#nominal_budget1');
            // nominal_budget2 = $('#nominal_budget2');
            note_budget = $('#note_budget');
            console.info("nama_biaya " + nama_biaya.val());
            // console.info(nama_biaya_val.length);

            if (company_id.val() == 'default') {
                //promo.removeClass('is-invalid');
                company_id.addClass('is-invalid');
                company_id.focus();
            } else if (nama_biaya.val() == 'default' || nama_biaya.val() == 'null' || nama_biaya.val() == null) {
                //promo.removeClass('is-invalid');
                nama_biaya.addClass('is-invalid');
                nama_biaya.focus();
            } else if (bulan_biaya.val() == 'default_biaya') {
                nama_biaya.removeClass('is-invalid');
                bulan_biaya.addClass('is-invalid');
                bulan_biaya.focus();
            } else if (tahun_budget.val() == 'default_tahun') {
                bulan_biaya.removeClass('is-invalid');
                tahun_budget.addClass('is-invalid');
                tahun_budget.focus();
                // } else if (nominal_budget.val() == '') {
                //     tahun_budget.removeClass('is-invalid');
                //     nominal_budget.addClass('is-invalid');
                //     nominal_budget.focus();
            } else {
                nama_biaya.addClass('is-invalid');
                nama_biaya.removeClass('is-invalid');
                bulan_biaya.removeClass('is-invalid');
                tahun_budget.removeClass('is-invalid');
                //note_budget.removeClass('is-invalid');

                $('#hide').show();
                $('#close_budget').hide();
                $('#save_budget').hide();

                var formdata = new FormData($('#form_budget')[0]);
                url = "<?php echo site_url('eaf/budget/insert'); ?>";

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressUpload, false);
                ajax.open("POST", url, true);
                ajax.send(formdata);
                ajax.onload = function() {
                    console.log('DONE: ', ajax.status);
                    if (ajax.status == 200) {
                        $('#form_budget')[0].reset();
                        $('#hide').hide();
                        $('#close_budget').show();
                        $('#save_budget').show();
                        document.getElementById("bar").style.width = 0;
                        document.getElementById("status").innerHTML = '';

                        $('#dt_budget').DataTable().ajax.reload();

                        $('#modal_add_budget').modal('hide');

                        swal("Success!", "Budget has been saved", "success");
                    }
                };

            }
        });

        $('#btn_penambahan').on('click', function() {
            nominal_tambah = $('#nominal_tambah');
            berita_acara = $('#berita_acara');
            // add by Ade
            var nama_biaya_tambah = $('#nama_biaya_tambah').val();
            var jumlah_nominal_tambah = $('#nominal_tambah').val();
            var note_penambahan = $('#note_penambahan').val();

            let tanggal_input = new Date();
            tanggal_input = tanggal_input.toISOString().split('T')[0];

            // add by Ade
            console.log('save penambahan..');
            no_hp = $('#no_hp_tambah').val();


            if (nominal_tambah.val() == '') {
                //tahun_budget.removeClass('is-invalid');
                nominal_tambah.addClass('is-invalid');
                nominal_tambah.focus();
            } else if (berita_acara.val() == '') {
                berita_acara.addClass('is-invalid');
                berita_acara.focus();
            } else {
                $('#btn_penambahan').prop('disabled', true);
                nominal_tambah.removeClass('is-invalid');
                berita_acara.removeClass('is-invalid');
                //$('#btn_penambahan').hide();
                url = "<?php echo site_url('eaf/budget/insert_penambahan'); ?>";
                form = $('#form_penambahan');
                $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "data": form.serialize(),
                    "url": url,
                    "success": function(response) {
                        $('#btn_penambahan').prop('disabled', false);
                        $('#form_penambahan')[0].reset();
                        swal("Success!", "Penambahan budget berhasil", "success");
                        $('#modal_penambahan').modal('hide');
                        $('#modal_add_penambahan').modal('hide');
                        $('#dt_budget').DataTable().ajax.reload();
                        $(".fa_done").hide();

                        // add by Ade
                        if (no_hp != null) {
                            // var list_phone = [];
                            // list_phone.push(no_hp)
                            // console.log(list_phone);
                            var list_phone = '087829828061';
                            message = `*💸 Informasi Penambahan Budget* \n\nRincian lengkap penambahan biaya adalah sebagai berikut: \n\n📝 Budget: *${nama_biaya_tambah}* \n💵 Jumlah: *Rp. ${formatNumberMinus(jumlah_nominal_tambah)}* \n🕐 Tanggal Efektif: *${tanggal_input}* \n 📄 Keterangan: *${note_penambahan}* \n\nTerima kasih atas perhatian dan pengertiannya.`;
                            // send_wa(list_phone, message);
                        }

                        reload_table_penambahan();
                    }
                })
            }


        });

        //Progress Bar
        function progressUpload(event) {
            var percent = (event.loaded / event.total) * 100;
            document.getElementById("bar").style.width = Math.round(percent) + '%';
            document.getElementById("status").innerHTML = Math.round(percent) + "% completed";
        }

        function progressUploadEdit(event) {
            var percent = (event.loaded / event.total) * 100;
            document.getElementById("bar_edit").style.width = Math.round(percent) + '%';
            document.getElementById("status_edit").innerHTML = Math.round(percent) + "% completed";
        }
    }); // End of document ready

    function filter_report()
        {
            period = $('#periode').val();
            // untuk export excel berdasarkan filter date
            // $('#datestart').val(datestart);
            // $('#dateend').val(dateend);

            year = period.substr(0, 4);
            month = period.substr(5, 2);

            list_budget(year, month);
    };

    function list_budget(year, month) {
        url = "<?= site_url('eaf/budget/data_budget') ?>";
        var table_budget = $('#dt_budget').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "order": [
                [0, "asc"]
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: "<?= $pageTitle ?>",
                footer: true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row:first c', sheet).attr('s', '2');
                }
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    year: year,
                    month: month
                },
                "url": url,
            },
            "columns": [{
                    "data": "company_name"
                }, {
                    "data": "nama_biaya",
                    "render": function(data, type, row) {
                        // if (row['budget'] == null) {
                        //     return `${data}`;
                        // } else {
                        // add row no_hp by Ade
                        return '<a href="javascript:void(0)" class="badge bg-success penambahan_biaya" data-id_biaya="' + row['id_biaya'] + '" data-budget="' + row['budget'] + '" data-bulan="' + row['bulan'] + '" data-tahun_nih="' + row['tahun_budget'] + '" data-nama_biaya="' + row['nama_biaya'] + '" data-no_hp="' + row['no_hp1'] + '">' + data + '</a>';
                        // }
                    }
                },
                {
                    "data": "user"
                },
                // {
                //     "data": "budget2",
                //     'render': function(data, type, row) {
                //         if (data == null) {
                //             return ``;
                //         } else {
                //             return 'Rp. ' + formatNumberMinus(data);
                //         }
                //     }
                // },
                {
                    "data": "budget",
                    'render': function(data, type, row) {
                        if (data == null) {
                            return `<span class="badge bg-success">Unlimited</span>`;
                        } else {
                            return 'Rp. ' + formatNumberMinus(data);
                        }
                    }
                    // $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                },
                {
                    "data": "minggu"
                },
                {
                    "data": "bulan"
                },
                {
                    "data": "tahun_budget"
                },
                {
                    "data": "note_budget"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "id_budget"
                },
                {
                    "data": "company_id"
                }
            ]
        });
    }

    function formatNumberMinus(num) {
        if (num == null) {
            return 0;
        } else {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function reload_table_penambahan() {
        id_biayaa_s = $("#id_biaya_tam").val();
        //id_biaya_tam = $('#id_biaya_tam').val();
        sisa_budget_s = $('#sisa_budget').val();
        minggu_s = $('#minggu_tam').val();
        bulan_s = $('#bulan_tam').val();
        tahun_s = $('#tahun_tam').val();

        url_2 = "<?php echo site_url(); ?>eaf/budget/data_budget_tambah";
        $('#dt_list_penambahan').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": url_2,
                "data": {
                    id_biayaa_s: id_biayaa_s,
                    sisa_budget_s: sisa_budget_s,
                    minggu_s: minggu_s,
                    bulan_s: bulan_s,
                    tahun_s: tahun_s
                }
            },
            "columns": [{
                    "data": "nominal_tambah",
                    'render': $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                },
                {
                    "data": "bulan"
                },
                {
                    "data": "tahun"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "employee_name"
                },
                {
                    "data": "note_penambahan"
                },
                {
                    "data": "ba",
                    "render": function(data, type, row) {
                        return '<a href="<?= base_url() ?>uploads/eaf/' + data + '" class="btn btn-success btn-sm penambahan_biaya">' + data + '</a>'
                    }
                }
            ]
        });
    }

    function formatRupiahInput(input) {
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
        let formattedValue = formatRupiahInput(inputField.value);
        inputField.value = formattedValue;
    }
</script>