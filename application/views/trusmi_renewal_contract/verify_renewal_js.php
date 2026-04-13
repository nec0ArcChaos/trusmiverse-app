<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url(); ?>assets/data-table/extensions/select/js/dataTables.select.min.js"></script>


<script>
    $(document).ready(function () {

        // PROAKTIF
        $('.group_star_1').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_proaktif_belajar']").val(index);

            // Reset semua bintang
            $(".group_star_1").removeClass("bi-star-fill");
            $(".group_star_1").addClass("bi-star");

            // Tambahkan warna emas ke bintang yang diklik dan sebelumnya
            $(".group_star_1").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        $('.group_star_2').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_proaktif_evaluasi']").val(index);

            // Reset semua bintang
            $(".group_star_2").removeClass("bi-star-fill");
            $(".group_star_2").addClass("bi-star");

            // Tambahkan warna emas ke bintang yang diklik dan sebelumnya
            $(".group_star_2").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        $('.group_star_3').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_proaktif_adaptasi']").val(index);

            // Reset semua bintang
            $(".group_star_3").removeClass("bi-star-fill");
            $(".group_star_3").addClass("bi-star");

            // Tambahkan warna emas ke bintang yang diklik dan sebelumnya
            $(".group_star_3").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        // PEMBELAJAR
        $('.g_star_pembelajar_a').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_pembelajar_berani']").val(index);

            $(".g_star_pembelajar_a").removeClass("bi-star-fill");
            $(".g_star_pembelajar_a").addClass("bi-star");

            $(".g_star_pembelajar_a").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        $('.g_star_pembelajar_b').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_pembelajar_berjuang']").val(index);

            $(".g_star_pembelajar_b").removeClass("bi-star-fill");
            $(".g_star_pembelajar_b").addClass("bi-star");

            $(".g_star_pembelajar_b").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        $('.g_star_pembelajar_c').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_pembelajar_melakukan']").val(index);

            $(".g_star_pembelajar_c").removeClass("bi-star-fill");
            $(".g_star_pembelajar_c").addClass("bi-star");

            $(".g_star_pembelajar_c").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        // ENERGI POSITIF
        $('.g_star_energi_a').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_energi_harmonis']").val(index);

            $(".g_star_energi_a").removeClass("bi-star-fill");
            $(".g_star_energi_a").addClass("bi-star");

            $(".g_star_energi_a").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        $('.g_star_energi_b').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_energi_motivasi']").val(index);

            $(".g_star_energi_b").removeClass("bi-star-fill");
            $(".g_star_energi_b").addClass("bi-star");

            $(".g_star_energi_b").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        $('.g_star_energi_c').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_energi_tauladan']").val(index);

            $(".g_star_energi_c").removeClass("bi-star-fill");
            $(".g_star_energi_c").addClass("bi-star");

            $(".g_star_energi_c").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

        // PENILAIAN USER INTERNAL
        $('.g_star_internal_a').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_internal_percepatan']").val(index);

            $(".g_star_internal_a").removeClass("bi-star-fill");
            $(".g_star_internal_a").addClass("bi-star");

            $(".g_star_internal_a").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });
        $('.g_star_internal_b').click(function () {
            let index = $(this).data("index"); // Ambil index bintang yang diklik

            $("input[name='rating_internal_disiplin']").val(index);

            $(".g_star_internal_b").removeClass("bi-star-fill");
            $(".g_star_internal_b").addClass("bi-star");

            $(".g_star_internal_b").each(function () {
                if ($(this).data("index") <= index) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                }
            });
        });

    });

    function pilih_status() {
        status = $("#status :selected").val();
        if (status == '1') {  // 1 : Perpanjang
            $('#feedback_label').html("Feedback Pekerjaan");
            $('#i_feedback').html(`<i class="bi bi-card-checklist"></i>`);
            $('#input_lama_kontrak').show();
            $('#input_membuat_fpk').hide();
            $('#membuat_fpk').val('tidak');
        } else { // 2 : Tidak Perpanjang
            $('#feedback_label').html("Alasan");
            $('#i_feedback').html(`<i class="bi bi-card-text"></i>`);
            $('#input_lama_kontrak').hide();
            $('#lama_kontrak').val("");
            $('#input_membuat_fpk').show();
        }
    }

    function input_feedback() {
        feedback = $('#feedback').val();
        if (feedback == "") {
            $("#feedback").addClass("is-invalid");
        } else {
            $("#feedback").removeClass("is-invalid");
        }
    }

    function select_lama_kontrak() {
        lama_kontrak = $("#lama_kontrak :selected").val();
        if (lama_kontrak == "") {
            $("#lama_kontrak").addClass("is-invalid");
        } else {
            $("#lama_kontrak").removeClass("is-invalid");
        }
    }

    function save_renewal() {
        form = $('#form_renewal');
        status = $("#status :selected").val();
        feedback = $('#feedback').val();
        lama_kontrak = $("#lama_kontrak :selected").val();

        // addnew
        rating_proaktif_belajar = $("input[name='rating_proaktif_belajar']").val();
        rating_proaktif_evaluasi = $("input[name='rating_proaktif_evaluasi']").val();
        rating_proaktif_adaptasi = $("input[name='rating_proaktif_adaptasi']").val();
        rating_pembelajar_berani = $("input[name='rating_pembelajar_berani']").val();
        rating_pembelajar_berjuang = $("input[name='rating_pembelajar_berjuang']").val();
        rating_pembelajar_melakukan = $("input[name='rating_pembelajar_melakukan']").val();
        rating_energi_harmonis = $("input[name='rating_energi_harmonis']").val();
        rating_energi_motivasi = $("input[name='rating_energi_motivasi']").val();
        rating_energi_tauladan = $("input[name='rating_energi_tauladan']").val();
        rating_internal_percepatan = $("input[name='rating_internal_percepatan']").val();
        rating_internal_disiplin = $("input[name='rating_internal_disiplin']").val();

        if (feedback == "") {
            $("#feedback").addClass("is-invalid");
            $("#feedback").focus();
        } else if (status == '1' && lama_kontrak == '') {
            $("#lama_kontrak").addClass("is-invalid");
            $("#lama_kontrak").focus();
            // addnew
        } else if ($("#masih_sesuai").val() == '#') {
            $("#masih_sesuai").addClass("is-invalid");
            $("#masih_sesuai").focus();
        } else if (status == '1' && $("#file_kpi").val() == '') {
            $("#file_kpi").addClass("is-invalid");
            $("#file_kpi").focus();
        } else if (rating_proaktif_belajar == 0 || rating_proaktif_evaluasi == 0 || rating_proaktif_adaptasi == 0 || rating_pembelajar_berani == 0 || rating_pembelajar_berjuang == 0 || rating_pembelajar_melakukan == 0 || rating_energi_harmonis == 0 || rating_energi_motivasi == 0 || rating_energi_tauladan == 0 || rating_internal_percepatan == 0 || rating_internal_disiplin == 0) { // addnew
            alert("Silahkan isi semua rating penilaian terlebih dahulu!");
            // $(".div_penilaian").focus();
        } else {

            $('#modalAddConfirm').modal('show');

        }
    }

    // function updateContractRenewal(){

    //     // form = $('#form_renewal');
    //     // console.log('form renewal: ', form.serialize());

    //     // addnew
    //     let form = document.getElementById('form_renewal');
    //     let form_data = new FormData(form);
    //     console.log(form_data);

    //     $.ajax({
    //         url: '<?= base_url(); ?>trusmi_renewal_contract/save_renewal',
    //         type: 'POST',
    //         dataType: 'json',
    //         // data: form.serialize(),
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         data: form_data,
    //         beforeSend: function() {

    //         },
    //         success: function(response) {
    //             // console.log('res: ', response);

    //             if (response.upload == 'error') {
    //                 alert('Upload file error, silahkan ulangi lagi!');
    //                 $('#modalAddConfirm').modal('hide');
    //                 return;
    //             }


    //             // nama = $('#nama_karyawan').text();
    //             // jabatan = $('#jabatan').text();
    //             // departemen = $('#departemen').text();
    //             // perusahaan = $('#company').text();
    //             // habis_kontrak = $('#habis_kontrak').text();
    //             status = $('#status :selected').text();
    //             lama_kontrak = $('#lama_kontrak :selected').text();

    //             nama = response.employee.nama;
    //             jabatan = response.employee.jabatan;
    //             departemen = response.employee.departemen;
    //             perusahaan = response.employee.company;
    //             habis_kontrak = response.employee.habis_kontrak;

    //             feedback = $('#feedback').val();
    //             approval = $('#approval').val();
    //             bulan_lama_kontrak = $('#lama_kontrak :selected').val();
    //             id_status = $('#status :selected').val();
    //             if(id_status == '1'){ // 1 : Perpanjang Kontrak
    //                 masa_perpanjang = `\nMasa Perpanjang : *${$.trim(lama_kontrak)}*`;
    //             }else{
    //                 masa_perpanjang = ``;
    //             }

    //             approval_at = "<?= date('Y-m-d H:i:s') ?>";


    //             msg_keputusan = `📣 *Keputusan Perpanjangan Kontrak* 📣\n\nNama : *${$.trim(nama)}*\nJabatan : ${jabatan}\nDepartemen : ${departemen}\nPerusahan : ${perusahaan}\n\nStatus Kontrak : *${$.trim(status)}*\nAlasan : ${feedback}${masa_perpanjang}\nApproval By : ${approval}\nApproval Date : ${$.trim(approval_at)}`;

    //             comben = [
    //                 '6281120012145', // comben
    //                 '6282262838929', // syifa1395
    //                 // '6282316041423', // ari
    //             ];

    //             // console.info(msg_keputusan);



    //             mulai_tanggal = moment(habis_kontrak).add(1, "days");
    //             berakhir_tanggal = moment(mulai_tanggal).add(bulan_lama_kontrak, "months");

    //             msg_perpanjangan = `📃 *Notifikasi Perpanjangan Kontrak* 📃\n\nKami ingin memberitahukan bahwa kontrak kerja Anda :\nNama : ${$.trim(nama)}\nJabatan : ${jabatan}\nStatus Kontrak : *${$.trim(status)}*\n\nKami menghargai kontribusi Anda dan melihat potensi dalam kinerja Anda selama masa kontrak sebelumnya.\n\nPerpanjangan kontrak kerja ini berlaku mulai tanggal ${convert_tanggal(mulai_tanggal.format('YYYY-MM-DD'))} dan akan berakhir pada tanggal ${convert_tanggal(berakhir_tanggal.format('YYYY-MM-DD'))} (${lama_kontrak}).\n\nKami berharap Anda akan terus memberikan dedikasi dan kinerja yang baik. Selain itu, dalam periode perpanjangan kontrak ini,\nkami juga berharap Anda dapat terus mengembangkan keterampilan dan pengetahuan Anda yang relevan dengan pekerjaan Anda.\n\nKami akan memberikan informasi lebih lanjut mengenai perpanjangan kontrak ini, termasuk segala persyaratan tambahan atau perubahan yang perlu Anda ketahui.\n\nTerima kasih atas kerja keras dan dedikasi Anda selama ini. Kami berharap kerjasama yang baik dan masa depan yang sukses bersama Anda di Trusmi Group.\n\nHormat kami,\nHR Trusmi Group`;
    //             no_hp = $('#no_hp').val();
    //             employee = [
    //                 no_hp,
    //                 '6281120012145', // comben
    //                 '6282262838929', // syifa1395
    //                 // '6282316041423', // ari
    //             ];
    //             // console.info(msg_perpanjangan);





    //             send_comben = send_wa_hr(comben, msg_keputusan);

    //             if(send_comben.wa.length == send_comben.total_done){
    //                 if(id_status == '1'){
    //                     send_employee = send_wa_hr(employee, msg_perpanjangan);
    //                     if(send_employee.wa.length == send_employee.total_done){
    //                         location.reload();
    //                     }
    //                 }
    //             }


    //         },
    //         error: function(xhr) { // if error occured

    //         },
    //         complete: function() {

    //         },
    //     });
    // }

    function updateContractRenewal() {
        let form = document.getElementById('form_renewal');
        let form_data = new FormData(form);

        $.ajax({
            url: '<?= base_url(); ?>trusmi_renewal_contract/save_renewal',
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            beforeSend: function () {
                $('#btn_save_confirm').attr('disabled', true).html('Processing...');
            },
            success: function (response) {
                console.info('Response:', response);

                if (response.upload == 'error') {
                    alert('Upload file error, silahkan ulangi lagi!');
                    $('#modalAddConfirm').modal('hide');
                    $('#btn_save_confirm').attr('disabled', false).html('Yes, Save');
                    return;
                }

                // Ambil data dari response & form
                let status = $('#status :selected').text();
                let lama_kontrak = $('#lama_kontrak :selected').text();
                let nama = response.employee.nama;
                let jabatan = response.employee.jabatan;
                let departemen = response.employee.departemen;
                let perusahaan = response.employee.company;
                let habis_kontrak = response.employee.habis_kontrak;

                let feedback = $('#feedback').val();
                let approval = $('#approval').val();
                let bulan_lama_kontrak = $('#lama_kontrak :selected').val();
                let id_status = $('#status :selected').val();
                let masa_perpanjang = '';

                if (id_status == '1') { // 1 : Perpanjang Kontrak
                    masa_perpanjang = `\nMasa Perpanjang : *${$.trim(lama_kontrak)}*`;
                }

                let approval_at = "<?= date('Y-m-d H:i:s') ?>";

                // ====== Pesan Keputusan ke HR ======
                let msg_keputusan = `📣 *Keputusan Perpanjangan Kontrak* 📣\n\nNama : *${$.trim(nama)}*\nJabatan : ${jabatan}\nDepartemen : ${departemen}\nPerusahaan : ${perusahaan}\n\nStatus Kontrak : *${$.trim(status)}*\nAlasan : ${feedback}${masa_perpanjang}\nApproval By : ${approval}\nApproval Date : ${$.trim(approval_at)}`;

                // Nomor Comben / HR
                let contact = [
                    '6281120012145', // comben
                    '6282262838929', // syifa1395
                    // '62882000489612',
                    // '6282316041423', // ari
                ];

                // ====== Pesan ke Employee (kalau perpanjangan) ======
                let mulai_tanggal = moment(habis_kontrak).add(1, "days");
                let berakhir_tanggal = moment(mulai_tanggal).add(bulan_lama_kontrak, "months");

                let msg_perpanjangan = `📃 *Notifikasi Perpanjangan Kontrak* 📃\n\nKami ingin memberitahukan bahwa kontrak kerja Anda :\nNama : ${$.trim(nama)}\nJabatan : ${jabatan}\nStatus Kontrak : *${$.trim(status)}*\n\nKami menghargai kontribusi Anda dan melihat potensi dalam kinerja Anda selama masa kontrak sebelumnya.\n\nPerpanjangan kontrak kerja ini berlaku mulai tanggal ${convert_tanggal(mulai_tanggal.format('YYYY-MM-DD'))} dan akan berakhir pada tanggal ${convert_tanggal(berakhir_tanggal.format('YYYY-MM-DD'))} (${lama_kontrak}).\n\nKami berharap Anda akan terus memberikan dedikasi dan kinerja yang baik. Selain itu, dalam periode perpanjangan kontrak ini,\nkami juga berharap Anda dapat terus mengembangkan keterampilan dan pengetahuan Anda yang relevan dengan pekerjaan Anda.\n\nKami akan memberikan informasi lebih lanjut mengenai perpanjangan kontrak ini, termasuk segala persyaratan tambahan atau perubahan yang perlu Anda ketahui.\n\nTerima kasih atas kerja keras dan dedikasi Anda selama ini. Kami berharap kerjasama yang baik dan masa depan yang sukses bersama Anda di Trusmi Group.\n\nHormat kami,\nHR Trusmi Group`;

                let no_hp = $('#no_hp').val();
                let contact_employee = [no_hp];
                let messages_employee = [msg_perpanjangan];
                let employees_employee = [response.employee.id];

                //HR
                let messages = [msg_keputusan, msg_perpanjangan];
                let employees = [response.employee.id, response.employee.id];
                let attachment = '';

                // ============= Kirim WA ke HR dulu =============
                $.each(contact, function (index, value) {
                    let messages_converted = msg_keputusan;
                    send_wa_trusmi_new(value, messages_converted, 0, 'text');
                });

                // ============= Kalau perpanjangan, kirim ke employee juga =============
                if (id_status == '1') {
                    setTimeout(() => {
                        $.each(contact_employee, function (index, value) {
                            let messages_converted = msg_perpanjangan;
                            send_wa_trusmi_new(value, messages_converted, 0, 'text');
                        });

                        $.each(contact, function (index, value) {
                            let messages_converted = msg_perpanjangan;
                            send_wa_trusmi_new(value, messages_converted, 0, 'text');
                        });
                    }, 1500);
                }

                // ====== Alert dan reload ======
                setTimeout(() => {
                    success_alert('Pesan WhatsApp berhasil dikirim!');
                    $('#modalAddConfirm').modal('hide');
                    $('#btn_save_confirm').attr('disabled', false).html('Yes, Save');

                    // Redirect jika Membuat FPK = Ya
                    var fpkEl = document.getElementById('membuat_fpk');
                    if (fpkEl && fpkEl.value === 'ya') {
                        var empId = $('#employee_id').val();
                        window.location.href = 'https://trusmiverse.com/apps/recruitment/permintaan_karyawan?employee_id=' + empId;
                    } else {
                        location.reload();
                    }
                }, 3000);
            },
            error: function (xhr) {
                console.error(xhr);
                error_alert('Terjadi kesalahan saat menyimpan data!');
                $('#btn_save_confirm').attr('disabled', false).html('Yes, Save');
            },
            complete: function () {
                // opsional
            }
        });
    }


    function send_wa_trusmi_new(phone, msg, user_id, tipe, url = '', filename = '') {
        $.ajax({
            url: "<?= base_url('trusmi_renewal_contract/send_wa_blast') ?>",
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({
                phone: phone,
                tipe: tipe,
                user_id: user_id,
                url: url,
                filename: filename,
                msg: msg
            }),
            success: function (response) {
                console.log(`✅ WA sent to ${phone}`, response);
            },
            error: function (err) {
                console.error(`❌ Error sending WA to ${phone}`, err);
            },
        });
    }


    function convert_tanggal(tanggal) {
        tahun = tanggal.substr(0, 4);
        bulan = tanggal.substr(5, 2);
        tanggal = tanggal.substr(8, 2);

        switch (bulan) {
            case '01':
                nama_bulan = "Januari";
                break;
            case '02':
                nama_bulan = "Februari";
                break;
            case '03':
                nama_bulan = "Maret";
                break;
            case '04':
                nama_bulan = "April";
                break;
            case '05':
                nama_bulan = "Mei";
                break;
            case '06':
                nama_bulan = "Juni";
                break;
            case '07':
                nama_bulan = "Juli";
                break;
            case '08':
                nama_bulan = "Agustus";
                break;
            case '09':
                nama_bulan = "September";
                break;
            case '10':
                nama_bulan = "Oktober";
                break;
            case '11':
                nama_bulan = "November";
                break;
            case '12':
                nama_bulan = "Desember";
                break;
            default:
                nama_bulan = "";
        }

        return `${tanggal} ${nama_bulan} ${tahun}`
    }




    // OLD
    function dt_verify_resignation() {
        id_resignation = "<?= $_GET['id'] ?>";
        $('#dt_verify_resignation').DataTable({
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "order": [
                [0, 'asc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>trusmi_resignation/dt_verify_resignation",
                "data": {
                    id_resignation: id_resignation,
                }
            },
            select: {
                style: 'multi'
            },
            dom: 'Bfrtip',
            buttons: [
                'selectAll',
                'selectNone',
            ],
            "columns": [{
                "data": "subclearance",
            },
            {
                "data": "status_resignation",
                "render": function (data, type, row, meta) {
                    if (row['id_status_resignation'] == 0) {

                        return `<span class="badge bg-danger data-resignation"
                            data-index="${meta.row}" 
                            data-id_status_resignation="${row['id_status_resignation']}" 
                            data-id_exit_clearance="${row['id_exit_clearance']}" 
                            data-id_resignation="${row['id_resignation']}" 
                            data-pic="${row['pic']}" 
                            > ${data}</span>`;
                    } else {

                        return `<span class="badge bg-success data-resignation"
                            data-index="${meta.row}" 
                            data-id_status_resignation="${row['id_status_resignation']}" 
                            data-id_exit_clearance="${row['id_exit_clearance']}" 
                            data-id_resignation="${row['id_resignation']}" 
                            data-pic="${row['pic']}" 
                            > ${data}</span>`;
                    }
                },
            },
            ],
            "initComplete": function (settings, response) {
                count_data = 0;
                for (let index = 0; index < response.data.length; index++) {
                    if (response.data[index].id_status_resignation > 0) {
                        count_data = parseInt(count_data) + 1;
                    }
                }
                // console.log(count_data);
                // console.log(response.data.length);
                if (response.data.length == count_data) {
                    // console.log("test");
                    $(".dt-button").hide();
                    $(".dt-button").hide();
                    $("#btn_approve_exit_clearance").hide();
                }
            },
        });
    }

    function div_verify_resignation() {
        id_resignation = "<?= $_GET['id'] ?>";
        $.ajax({
            url: '<?= base_url(); ?>trusmi_resignation/dt_verify_resignation',
            type: 'POST',
            dataType: 'json',
            data: {
                id_resignation: id_resignation
            },
            beforeSend: function () {

            },
            success: function (response) {
                // console.log(response.data);
                componentItem = '';

                for (let index = 0; index < response.data.length; index++) {
                    if (response.data[index].id_status_resignation == 0) {
                        status_clearance = `<span class="badge bg-danger">${response.data[index].status_resignation}</span>`;
                    } else if (response.data[index].id_status_resignation == 1) {
                        status_clearance = `<span class="badge bg-success">${response.data[index].status_resignation}</span>`;
                    } else {

                    }
                    componentItem += `
                            <div class="col-lg-6 col-md-12 col-sm-12" style="margin-top:5px;margin-bottom:5px;">
                                <div class="card">
                                    <div class="card-body" style="background-color: #F6F7FB;">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12" style="text-align: right;">
                                                ${status_clearance}
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="">${response.data[index].subclearance}</label>
                                            </div>
                                            <form id='form_exit_clearance_${response.data[index].id_exit_clearance}'>
                                                <div class="col-sm-12" style="margin-bottom: 5px;margin-top: 5px;">
                                                    <input type="hidden" name="id_resignation" value="<?= $_GET['id'] == null ? '' : $_GET['id']; ?>" readonly>
                                                    <input type="hidden" name="pic" value="<?= $this->session->userdata("user_id"); ?>" readonly>
                                                    <input type="hidden" name="status" id="status_resignation" readonly>
                                                    <div class="input-group input-group-lg">
                                                        <div class="form-floating">
                                                            <textarea name="pernyataan_1" id="pernyataan_1" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required=""></textarea>
                                                            <label>Note : </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="col-sm-2 col-md-4 col-lg-6">
                                            </div>
                                            <div class="col-sm-10 col-md-8 col-lg-6" style="text-align: right;">
                                                <button type="button" class="btn btn-md btn-outline-danger" style="margin: 5px;" onclick="approveResignation('${response.data[index].id_exit_clearance}','2')">Reject</button>
                                                <button type="button" class="btn btn-md btn-outline-theme" style="margin: 5px;" onclick="approveResignation('${response.data[index].id_exit_clearance}','1')">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                }
                $("#div_verify_resignation").empty();
                $("#div_verify_resignation").append(componentItem);
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }


    var table = $('#dt_verify_resignation').DataTable();
    $('#dt_verify_resignation tr').on('click', function () {
        $(this).toggleClass('selected');
        var value = $(this).find('td:first').html();
    });

    table.on('select', function (e, dt, type, indexes) {
        $('#form_exit_clearance').empty();
        $("#dt_verify_resignation tr.selected").each(function (index, row) {
            getRowItem(
                $(row).find('td .data-resignation').data("id_exit_clearance"),
                $(row).find('td .data-resignation').data("id_resignation"),
                $(row).find('td .data-resignation').data("pic"),
                $(row).find('td .data-resignation').data("index"),
            );
        });
        checkLengthData($('.item').length)
    });
    table.on('deselect', function (e, dt, type, indexes) {
        $('#form_exit_clearance').empty();
        $("#dt_verify_resignation tr.selected").each(function (index, row) {
            getRowItem(
                $(row).find('td .data-resignation').data("id_exit_clearance"),
                $(row).find('td .data-resignation').data("id_resignation"),
                $(row).find('td .data-resignation').data("pic"),
                $(row).find('td .data-resignation').data("index"),
            );
        });
        checkLengthData($('.item').length)
    });

    function getRowItem(id_exit_clearance, id_resignation, pic, index) {
        // console.log(id_exit_clearance, id_resignation, pic, index);
        cart = '';
        cart += `
                <div class="row">
                    <input type="hidden" class="form-control col item item_${index}" readonly name="id_exit_clearance[]" value="${id_exit_clearance}" />
                    <input type="hidden" class="form-control col item item_${index}" readonly name="id_resignation[]" value="${id_resignation}" />
                    <input type="hidden" class="form-control col item item_${index}" readonly name="pic[]" value="${pic}" />
                </div>
                            `;
        $('#form_exit_clearance').append(cart);
    }

    function checkLengthData(length) {
        // alert(length);
        if (parseInt(length) < 1) {
            $('#btn_approve_exit_clearance').removeAttr("btn-primary");
            $('#btn_approve_exit_clearance').attr("disabled", true);
            $('#btn_approve_exit_clearance').attr("class", "btn btn-default");
            $('#btn_approve_exit_clearance').html("Silahkan pilih Exit Clearance");
        } else {
            $('#btn_approve_exit_clearance').removeAttr("btn-default");
            $('#btn_approve_exit_clearance').attr("disabled", false);
            $('#btn_approve_exit_clearance').attr("class", "btn btn-primary");
            $('#btn_approve_exit_clearance').html("Approve Exit Clearance");
        }
    }

    function approveResignation(id_exit_clearance, status_resignation) {
        $("#modalAddConfirm").modal("show");
        $("#u_id_exit_clearance").val(id_exit_clearance);
        $("#status_resignation").val(status_resignation);
        if (status_resignation == '1') {
            $("#btn_save_confirm").html('Yes, Approve');
            $("#btn_save_confirm").removeClass("btn-outline-danger");
            $("#btn_save_confirm").addClass("btn-outline-theme");
        } else if (status_resignation == '2') {
            $("#btn_save_confirm").html('Yes, Reject');
            $("#btn_save_confirm").removeClass("btn-outline-theme");
            $("#btn_save_confirm").addClass("btn-outline-danger");
        } else {
            $("#btn_save_confirm").html('Yes, Save');
            $("#btn_save_confirm").removeClass("btn-outline-danger");
            $("#btn_save_confirm").addClass("btn-outline-theme");
        }
    }


    function updateApproval() {
        let u_id_exit_clearance = $("#u_id_exit_clearance").val();
        form = $(`#form_exit_clearance_${u_id_exit_clearance}`);
        $.ajax({
            url: '<?= base_url('trusmi_resignation/update_approval') ?>',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            beforeSend: function () {
                $('#btn_save_confirm').attr('disabled', true);
                $("#btn_save_confirm").html("Please wait...");
            },
            success: function (response) {
                if (response.status == 200) {
                    success_alert('Approved');
                } else if (response.status == 409) {
                    error_alert('Failed');
                } else {
                    error_alert('Unrecognized Error');
                }
                form[0].reset();
                $("#modalAddConfirm").modal("hide");
                div_verify_resignation();
                checkLengthData(0);
            },
            error: function (xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function () {
                $('#btn_save_confirm').attr('disabled', false);
                $("#btn_save_confirm").html("Yes, Approve");
            },
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
</script>