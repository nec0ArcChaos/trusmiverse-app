<!-- Required Jquery -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<!-- data-table js -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- i18next.min.js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo-12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/dataTables.fixedColumns.min.js"></script>


<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>

<!-- ckeditor -->
<script src="<?php echo base_url(); ?>assets/pages/ckeditor/ckeditor.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/pages/wysiwyg-editor/wysiwyg-editor.js"></script> -->

<script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script>

<!-- jspdf -->
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.umd.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/html2canvas.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.plugin.autotable.js"></script>

<!-- slim select js -->
<script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script>


<script type="text/javascript">
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

        list_budget(year, month);

        $('#filter_period').on('click', function() {

            period = $('#period').val();
            // untuk export excel berdasarkan filter date
            // $('#datestart').val(datestart);
            // $('#dateend').val(dateend);

            year = period.substr(0, 4);
            month = period.substr(5, 2);


            list_budget(year, month);

            // $('#nama_biaya').on('change', function() { 
            //     value = ($(this).val() == null ? '2|2|' : $(this).val()); 
            //     data = value.split('|');
            //     console.log(data[0] + ',' + data[1] + ',' + data[2]);
            //     nama_biaya(data[1]);
            //     if (data[2] == '') {
            //         nominal_budget = '~';
            //     } else {
            //         nominal_budget = formatRupiah(data[2]);
            //     }
            //     // $('#budget').val(budget);
            //     // pengajuan = $('#get_nominal').val();
            //     // $('#pengajuan').val(formatRupiah(pengajuan));
            //     // if (budget == '~') {
            //     //     sisa_new = '~';
            //     // } else {
            //     //     sisa = parseInt(data[2]) - parseInt(pengajuan);
            //     //     sisa_new = formatRupiah(sisa.toString());
            //     // }
            //     // $('#sisa_new').val(sisa_new);
            //     // $('#get_id_biaya').val(data[0]);
            //     // $('#get_id_budget').val(data[1]);
            // });

        });


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
                            return '<a href="<?= base_url() ?>assets/uploads/eaf/' + data + '" class="label label-success penambahan_biaya">' + data + '</a>'
                        }
                    }
                ]
            });
        }

        $("input.numbers").keypress(function(event) {
            return /\d/.test(String.fromCharCode(event.keyCode));
        });

        $('#list_budget').on('click', function() {
            $('#modal_add_budget').modal({
                backdrop: 'static',
                keyboard: false
            });
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


        $('#hide').hide();

        $('#save_budget').on('click', function() {
            nama_biaya = $('#nama_biaya');
            minggu_biaya = $('#minggu_biaya');
            bulan_biaya = $('#bulan_biaya');
            tahun_budget = $('#tahun_budget');
            nominal_budget = $('#nominal_budget');
            note_budget = $('#note_budget');
            if (nama_biaya.val() == 'default') {
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
                            var list_phone = [];
                            list_phone.push(no_hp)
                            // console.log(list_phone);
                            message = `*💸 Informasi Penambahan Budget* \n\nRincian lengkap penambahan biaya adalah sebagai berikut: \n\n📝 Budget: *${nama_biaya_tambah}* \n💵 Jumlah: *Rp. ${formatNumberMinus(jumlah_nominal_tambah)}* \n🕐 Tanggal Efektif: *${tanggal_input}* \n 📄 Keterangan: *${note_penambahan}* \n\nTerima kasih atas perhatian dan pengertiannya.`;
                            send_wa(list_phone, message);
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


    }); //end ready function

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
                    "data": "nama_biaya",
                    "render": function(data, type, row) {
                        // if (row['budget'] == null) {
                        //     return `${data}`;
                        // } else {
                        // add row no_hp by Ade
                        return '<a href="javascript:void(0)" class="label label-success penambahan_biaya" data-id_biaya="' + row['id_biaya'] + '" data-budget="' + row['budget'] + '" data-bulan="' + row['bulan'] + '" data-tahun_nih="' + row['tahun_budget'] + '" data-nama_biaya="' + row['nama_biaya'] + '" data-no_hp="' + row['no_hp1'] + '">' + data + '</a>';
                        // }
                    }
                },
                {
                    "data": "user"
                },
                {
                    "data": "budget",
                    'render': function(data, type, row) {
                        if (data == null) {
                            return `<span class="badge badge-inverse-success">Unlimited</span>`;
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
</script>