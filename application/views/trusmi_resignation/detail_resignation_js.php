<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url(); ?>assets/data-table/extensions/select/js/dataTables.select.min.js"></script>


<script>
    $(document).ready(function() {
        // dt_verify_resignation();
        div_verify_resignation();
        get_profile_resignation();
        checkLengthData(0);
    });

    function get_profile_resignation() {
        id_resignation = '<?= $id_resignation ?>';
        $.ajax({
            url: '<?= base_url(); ?>trusmi_resignation/get_profile_resignation',
            type: 'POST',
            dataType: 'json',
            data: {
                id_resignation: id_resignation
            },
            beforeSend: function() {

            },
            success: function(response) {
                // console.log(response);
                // console.log(response.user_id);
                // console.log(response.employee_name);
                $("#employee_name").html(response.employee_name == null ? '<i class="small">*no data available</i>' : response.employee_name);
                $("#company_name").html(response.company_name == null ? '<i class="small">*no data available</i>' : response.company_name);
                $("#department_name").html(response.department_name == null ? '<i class="small">*no data available</i>' : response.department_name);
                $("#designation_name").html(response.designation_name == null ? '<i class="small">*no data available</i>' : response.designation_name);
                $("#contact_no").html(response.contact_no == null ? '<i class="small">*no data available</i>' : response.contact_no);
                $("#address").html(response.address == null ? '<i class="small">*no data available</i>' : response.address);
                $("#category").html(response.category == null ? '<i class="small">*no data available</i>' : response.category);
                $("#reason").html(response.reason == null ? '<i class="small">*no data available</i>' : response.reason);
                $("#note").html(response.note == null ? '<i class="small">*no data available</i>' : response.note);
                pp = `<figure class="avatar avatar-150 coverimg rounded-circle shadow-md">
                <img src="http://trusmiverse.com/hr/uploads/profile/${response.profile_picture}" alt="" id="" />
                </figure>`;
                $("#profile_picture").append(pp);
                $("#date_of_joining").html(response.date_of_joining == null ? '<i class="small">*no data available</i>' : moment(response.date_of_joining).format('DD-MM-YYYY'));
                $("#masa_kerja").html(response.masa_kerja == null ? '<i class="small">*no data available</i>' : response.masa_kerja);
                $("#habis_kontrak").html(response.habis_kontrak == null ? '<i class="small">*no data available</i>' : response.habis_kontrak);
                $("#terakhir_absen").html(response.terakhir_absen == null ? '<i class="small">*no data available</i>' : response.terakhir_absen);
                ses_user_id = '<?= $this->session->userdata('user_id') ?>';
                $('#tr_habis_kontrak').addClass('d-none')
                console.log(ses_user_id);
                if (ses_user_id == 1 || ses_user_id == 979 || ses_user_id == 78) {
                    setTimeout(() => {
                        $('#tr_habis_kontrak').removeClass('d-none')
                    }, 250);
                }
                if (response.company_id == '2') {
                    $.ajax({
                        url: '<?= base_url(); ?>trusmi_resignation/get_atasan_rsp',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            user_id: response.user_id
                        },
                        beforeSend: function() {

                        },
                        success: function(response_atasan) {
                            // console.log(response_atasan);
                            $("#nama_spv").html(response_atasan.nama_spv == null || response_atasan.id_user_spv == 1 || response_atasan.id_user_spv == 2 ? '<i class="small">*no data available</i>' : response_atasan.nama_spv);
                            $("#nama_mng").html(response_atasan.nama_mng == null || response_atasan.id_user_mng == 1 || response_atasan.id_user_mng == 2 ? '<i class="small">*no data available</i>' : response_atasan.nama_mng);
                        },
                        error: function(xhr) { // if error occured

                        },
                        complete: function() {

                        },
                    });
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function div_verify_resignation() {
        id_resignation = '<?= $id_resignation ?>';

        var table_pinjam = '';
        $.ajax({
            url: '<?= base_url() ?>trusmi_resignation/check_peminjaman_rakon',
            type: 'POST',
            dataType: 'json',
            data: {
                id_resignation: id_resignation
            },
            beforeSend: function() {

            },
            success: function(response) {
                if (response.data.length > 0) {
                    table_pinjam += `<table class="table table-sm" style="font-size:8pt;">
                    <thead>
                                        <tr>
                                        <th>No. Kode</th>
                                            <th>Barang</th>
                                            <th>Pinjam</th>
                                            <th>Kembali</th>
                                            <th>Sisa</th>
                                            </tr>
                                    </thead>
                                    <tbody>`;

                    for (let index = 0; index < response.data.length; index++) {
                        id_peminjam = response.data[index].id_peminjam;
                        no_adj = response.data[index].no_adj;
                        kode_barang = response.data[index].kode_barang;
                        nama_barang = response.data[index].nama_barang;
                        pinjam = response.data[index].pinjam;
                        kembali = response.data[index].kembali;
                        sisa = response.data[index].sisa;
                        table_pinjam += `<tr>
                                        <td>${kode_barang}<hr style="margin:0px;padding:0;">${no_adj}</td>
                                        <td>${nama_barang}</td>
                                        <td>${pinjam}</td>
                                        <td>${kembali}</td>
                                        <td>${sisa}</td>
                                        </tr>`
                    }

                    table_pinjam += `</tbody>
                                    </table>`;
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });

        $.ajax({
            url: '<?= base_url(); ?>trusmi_resignation/dt_my_resignation',
            type: 'POST',
            dataType: 'json',
            data: {
                id_resignation: id_resignation
            },
            beforeSend: function() {

            },
            success: function(response) {
                // console.log(response.data);
                componentItem = `<div class="col-lg-12 col-md-12 col-sm-12 fade-in" style="margin-top:5px;margin-bottom:5px;">
                                <div class="card">
                                    <div class="card-body" style="background-color: #F6F7FB;">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="" style="font-weight:bold;">Alasan Resign dari Atasan</label>
                                            </div>
                                                <div class="col-sm-12" style="margin-bottom: 5px;margin-top: 5px;">
                                                    <div class="input-group input-group-lg">
                                                        <div class="form-floating">
                                                            <textarea class="form-control border-start-0" cols="30" rows="5" style="min-height: 50px;" 
                                                                    required="" readonly>${response.data[0].reason_atasan == null ? "" : response.data[0].reason_atasan }</textarea>
                                                            <label>Note : </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-sm-2 col-md-4 col-lg-6">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                for (let index = 0; index < response.data.length; index++) {
                    if (response.data[index].id_status_resignation == 0) {
                        status_clearance = `<span class="badge bg-warning">${response.data[index].status_resignation}</span>`;
                    } else if (response.data[index].id_status_resignation == 1) {
                        status_clearance = `<span class="badge bg-success">${response.data[index].status_resignation}</span>`;
                    } else {
                        status_clearance = `<span class="badge bg-danger">${response.data[index].status_resignation}</span>`;
                    }
                    if (response.data[index].id_status_resignation == 1) {
                        btn_reject = ``;
                        btn_approve = ``;
                        text_note = `
                        <textarea name="note" id="note_${response.data[index].id_exit_clearance}" 
                            class="form-control border-start-0" cols="30" rows="5" style="min-height: 50px;" 
                            required="" readonly>${response.data[index].note == null ? "" : response.data[index].note }</textarea>
                            <label>Note : </label>`;
                    } else {
                        btn_reject = ``;
                        btn_approve = ``;
                        text_note = `
                            <textarea name="note" id="note_${response.data[index].id_exit_clearance}" 
                            class="form-control border-start-0" cols="30" rows="5" style="min-height: 50px;" 
                            required="" readonly>${response.data[index].note == null ? "" : response.data[index].note }</textarea>
                            <label>Note : </label>`;
                    }
                    diperiksa_oleh = '';
                    approved_at = '';
                    if (response.data[index].approved_at != '') {
                        diperiksa_oleh = `<span class="small">Diperiksa Oleh : ${response.data[index].diperiksa_oleh}</small>`;
                        approved_at = `<span class="small">Diperiksa Tgl : ${response.data[index].approved_at}</small>`;
                    } else {
                        diperiksa_oleh = ` <span class="small">Diperiksa Oleh : ${response.data[index].diperiksa_oleh}</small>`;
                        approved_at = `<span class="small">Diperiksa Tgl : </small>`;
                    }

                    // jika subclearance = peminjaman rakon
                    tanggungan_asset = '';
                    kunci_approve = '';
                    txt_info = '';
                    if (response.data[index].id_subclearance == 19) {
                        if (table_pinjam != '') {
                            tanggungan_asset += `
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-2">
                            <label for="" style="font-weight:bold;">List Peminjaman Asset</label>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12"> ${table_pinjam} </div>`;
                            kunci_approve = 1; // kunci tidak bisa approve
                        }
                    }

                    if (kunci_approve == 1) {
                        btn_reject = '<small>*tidak bisa di approve sebelum karyawan mengembalikan asset</small>';
                    }

                    componentItem += `
                            <div class="col-lg-6 col-md-12 col-sm-12 fade-in" style="margin-top:5px;margin-bottom:5px;">
                                <div class="card">
                                    <div class="card-body" style="background-color: #F6F7FB;">
                                        <div class="row">
                                            ${tanggungan_asset}
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="" style="font-weight:bold;">${response.data[index].subclearance}</label>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="text-align: left;"> 
                                                        ${diperiksa_oleh}
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="text-align: right;"> 
                                                        ${status_clearance}
                                                    </div>
                                                </div>
                                            </div>
                                            <form id='form_exit_clearance_${response.data[index].id_exit_clearance}'>
                                                <div class="col-sm-12" style="margin-bottom: 5px;margin-top: 5px;">
                                                    <input type="hidden" name="id_exit_clearance" value="${response.data[index].id_exit_clearance}" readonly>
                                                    <input type="hidden" name="id_resignation" value="<?= $_GET['id'] == null ? '' : $_GET['id']; ?>" readonly>
                                                    <input type="hidden" name="pic" value="<?= $this->session->userdata("user_id"); ?>" readonly>
                                                    <input type="hidden" name="status" id="status_resignation_${response.data[index].id_exit_clearance}" readonly>
                                                    <div class="input-group input-group-lg">
                                                        <div class="form-floating">
                                                            ${text_note}
                                                            ${approved_at}
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="col-sm-2 col-md-4 col-lg-6">
                                            </div>
                                            <div class="col-sm-10 col-md-8 col-lg-6" style="text-align: right;">
                                                ${btn_reject}
                                                ${btn_approve}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                }
                $("#div_verify_resignation").empty();
                $("#div_verify_resignation").append(componentItem);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }


    var table = $('#dt_verify_resignation').DataTable();
    $('#dt_verify_resignation tr').on('click', function() {
        $(this).toggleClass('selected');
        var value = $(this).find('td:first').html();
    });

    table.on('select', function(e, dt, type, indexes) {
        $('#form_exit_clearance').empty();
        $("#dt_verify_resignation tr.selected").each(function(index, row) {
            getRowItem(
                $(row).find('td .data-resignation').data("id_exit_clearance"),
                $(row).find('td .data-resignation').data("id_resignation"),
                $(row).find('td .data-resignation').data("pic"),
                $(row).find('td .data-resignation').data("index"),
            );
        });
        checkLengthData($('.item').length)
    });
    table.on('deselect', function(e, dt, type, indexes) {
        $('#form_exit_clearance').empty();
        $("#dt_verify_resignation tr.selected").each(function(index, row) {
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
</script>