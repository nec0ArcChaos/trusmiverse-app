<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            // dt_trusmi_resignation(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        dt_renewal();
    });


    function dt_renewal() {
        $('#dt_renewal').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [4, 'asc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "GET",
                "url": "<?= base_url(); ?>trusmi_renewal_contract_ade/list_renewal",
                // "data": {
                //     start: start,
                //     end: end,
                // }
            },
            "columns": [{
                    "data": "employee_name",
                    render: function(data, type, row, meta) {
                        user_id = '<?= $this->session->userdata('user_id'); ?>';
                        if (user_id == 1 || user_id == 979) {
                            resend_renewal = `<a href="javascript:void(0)" title="Kirim ulang renewal contract?" onclick="resend_renewal_contract(${row['id']})">
                                                <i class="bi bi-whatsapp text-success"></i>
                                            </a>`
                        } else {
                            resend_renewal = ``
                        }
                        return `${resend_renewal} ${data}`
                    }
                },
                {
                    "data": "department_name",
                    render: function(data, type, row, meta) {
                        return `<small>${data}</small> <br> <small>${row['designation_name']}</small>`
                    }
                },
                {
                    "data": "masa_kerja",
                    render: function(data, type, row, meta) {
                        masa_kerja = data.split(".");
                        if (masa_kerja[0] > 0) {
                            lama_tahun = `${masa_kerja[0]} Tahun`;
                        } else {
                            lama_tahun = "";
                        }

                        return `${lama_tahun} ${masa_kerja[1]} Bulan`
                    }
                },
                {
                    "data": "contract_end",
                },
                {
                    "data": "deadline",
                },
                {
                    "data": "sisa_hari",
                    render: function(data, type, row, meta) {
                        return `${row['sisa_hari']} Hari`
                    },
                    "className": "text-center"
                },
                {
                    "data": "wajib_feedback",
                    render: function(data, type, row, meta) {
                        if (row['wajib_feedback'] == 1) {
                            return `<span class="badge bg-danger">Lock Absen</span>`
                        } else {
                            return ``
                        }
                    }
                },
                {
                    "data": "head_name",
                },
                {
                    "data": "id",
                    render: function(data, type, row, meta) {

                        return `<a href="<?= base_url('trusmi_renewal_contract/verify?id=') ?>${data}" class="badge bg-blue" target="_blank"> <i class="bi bi-pen"></i> Feedback Renewal Contract</a> `
                    }
                },
                // addnew
                {
                    "data": "masih_sesuai", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },
                {
                    "data": "id", 
                },

            ],
        });
    }

    function resend_renewal_contract(id) {

        $.ajax({
            url: '<?= base_url('trusmi_renewal_contract/detail_renewal') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id: id
            },
            success: function(response) {
                // console.info(response)
                Swal.fire({
                    title: "Resend Renewal Contract?",
                    text: `${response.data.nama}`,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, resend!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        send_renewal(response);
                    }
                });
            },
            error: function(xhr) { // if error occured
                console.error(xhr);
            },
        });

    }


    function send_renewal(response) {


        var masaKerjaParts = response.data.masa_kerja.split(".");
        // console.info(masaKerjaParts);

        if (parseInt(masaKerjaParts[0]) > 0) {
            lama_tahun = masaKerjaParts[0] + " Tahun ";
        } else {
            lama_tahun = "";
        }

        masa_kerja = lama_tahun + masaKerjaParts[1] + " Bulan";

        const habis_kontrak = response.data.habis_kontrak.split("-");
        let bulan;

        switch (habis_kontrak[1]) {
            case "01":
                bulan = "Januari";
                break;
            case "02":
                bulan = "Februari";
                break;
            case "03":
                bulan = "Maret";
                break;
            case "04":
                bulan = "April";
                break;
            case "05":
                bulan = "Mei";
                break;
            case "06":
                bulan = "Juni";
                break;
            case "07":
                bulan = "Juli";
                break;
            case "08":
                bulan = "Agustus";
                break;
            case "09":
                bulan = "September";
                break;
            case "10":
                bulan = "Oktober";
                break;
            case "11":
                bulan = "November";
                break;
            case "12":
                bulan = "Desember";
                break;
            default:
                bulan = "";
        }

        var reminder = `📣📣 *Reminder Perpanjangan Kontrak* 📝📝
        
        Pemberitahuan ini menginformasikan bahwa kontrak kerja tim Anda.

        👤 Nama : *${response.data.nama.trim()}*
        🪑 Jabatan : ${response.data.designation}
        🏛️ Departemen : ${response.data.department}
        📍 Lokasi : ${response.data.lokasi}

        🖥️ Masa Kerja : ${masa_kerja}
        🕑 Kontrak Berakhir : ${habis_kontrak[2]} ${bulan} ${habis_kontrak[0]}
        ⌛ Sisa Kontrak : ${response.data.sisa_kontrak} Hari

        Mohon untuk dilakukan review dan pertimbangan perpanjangan kontrak tersebut, 
        keputusan perpanjangan kotrak dapat dilakukan melalui link berikut :
        🌎 https://www.trusmiverse.com/apps/login/verify_renewal?uid=${response.data.head_id}&id=${response.data.id_renewal}

        ⚠️* _Pesan reminder akan terkirim di H-45, H-30, H-16,_ 
        _Jika tidak ada keputusan H-16 dari tanggal berakhir kontrak,_ 
        _maka akan diberlakukan Lock Absen_`;


        let phone = response.data.head_contact;

        // Remove the first character
        phone = phone.substring(1);

        // Remove '+' characters
        phone = phone.replace(/\+/g, '');

        // Remove '-' characters
        phone = phone.replace(/-/g, '');

        // Remove space characters
        phone = phone.replace(/ /g, '');

        // Prepend '62' to the phone number
        phone = "62" + phone;


        console.info(reminder);
        console.info(phone);

        $.ajax({
            url: "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp",
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
                'API-Key': '40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1',
            },
            data: JSON.stringify({
                "channelID": "2225082380",
                "phone": phone,
                // "phone": '6281214926060',
                "messageType": "text",
                "body": reminder,
                "withCase": true
            }),
            success: function(data) {

            },
            complete: function(response) {
                if (response.status == 200) {

                    Swal.fire({
                        title: "Success",
                        text: "Notifikasi Renewal Contract Terkirim!",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Gagal mengirimkan notifikasi!",
                        text: response.error.message,
                        icon: "error",
                    });

                }
            },
            error: function(err) {
                swal("Terjadi kesalahan!", JSON.stringify(err), "error");
            }
        });



    }

    function save() {
        if ($('#company_id').val() == '') {
            error_alert("Company anda tidak terdeteksi di sistem");
            $('#company_id').focus();
        } else if ($('#employee_id').val() == '') {
            error_alert("Employee Id anda tidak terdeteksi di sistem");
            $('#employee_id').focus();
        } else if ($('#notice_date').val() == '') {
            error_alert("Notice Date tidak boleh kosong");
            $('#notice_date').focus();
        } else if ($('#resignation_date').val() == '') {
            error_alert("Resignation Date tidak boleh kosong");
            $('#resignation_date').focus();
        } else if ($('#reason').val() == '') {
            error_alert("Reason tidak boleh kosong");
            $('#reason').focus();
        } else if ($('#note').val() == '') {
            error_alert("Note tidak boleh kosong");
            $('#note').focus();
        } else if (
            $('#pernyataan_1').val() == '' ||
            $('#pernyataan_2').val() == '' ||
            $('#pernyataan_3').val() == '' ||
            $('#pernyataan_4').val() == '' ||
            $('#pernyataan_5').val() == '' ||
            $('#pernyataan_6').val() == '' ||
            $('#pernyataan_7').val() == '' ||
            $('#pernyataan_8').val() == '' ||
            $('#pernyataan_9').val() == '' ||
            $('#pernyataan_10').val() == ''
        ) {
            error_alert("Anda belum menjawab semua pertanyaan");
        } else {
            $("#modalAddConfirm").modal("show");
        }
    }

    function store_resignation() {
        form = $('#form_add');
        $.ajax({
            url: '<?= base_url('trusmi_resignation/store') ?>',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            beforeSend: function() {
                $('#btn_save_confirm').attr('disabled', true);
                $("#btn_save_confirm").html("Please wait...");
            },
            success: function(response) {
                if (response.status == 200) {
                    id_resignation = response.id_resignation;
                    username = '<?= $this->session->userdata('username'); ?>';
                    contact_no = response.contact_no;
                    requested_by = '<?= $this->session->userdata("nama"); ?>';
                    requested_at = '<?= date("Y-m-d") ?>';
                    requested_hour = '<?= date("H:i:s") ?>';

                    for (let index = 0; index < contact_no.length; index++) {
                        array_contact = [
                            '6281120012145',
                        ];
                        array_contact.push(contact_no[index].contact_no);
                        username = contact_no[index].username;
                        msg = `📣 Alert!!!
*There is New Request Exit Clearance*
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. Resignation : ${requested_by}
Subject : *Form Exit Clearance*

🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify_resignation?u=${username}&id=${id_resignation}`;
                        send_wa(array_contact, msg);
                    }
                    // console.log(contact_no);
                    // console.log(contact_no[0].contact_no);
                    // console.log(array_contact);
                    success_alert('Resignation Added');
                } else if (response.status == 409) {
                    error_alert('Failed');
                } else {
                    error_alert('Unrecognized Error');
                }
                form[0].reset();
                $("#modalAdd").modal("hide");
                $("#modalAddConfirm").modal("hide");
                dt_trusmi_resignation(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));
                selectReason.setSelected();
            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_save_confirm').attr('disabled', false);
                $("#btn_save_confirm").html("Yes, Save");
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