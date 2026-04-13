<!-- sweetalert -->
<!-- <script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>

<script>
$(document).ready(function () {
    var start = moment();
    var end = moment();

    function cb(start, end) {
        const today = moment().format('YYYY-MM-DD');
        const isToday = (start.format('YYYY-MM-DD') === today && end.format('YYYY-MM-DD') === today);

        $('#titlecalendar').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('input[name="start"]').val(start.format('YYYY-MM-DD'));
        $('input[name="end"]').val(end.format('YYYY-MM-DD'));

        if (isToday) {
            $('#btnBlastHariIni').prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
        } else {
            $('#btnBlastHariIni').prop('disabled', true).removeClass('btn-primary').addClass('btn-secondary');
        }

        load_birthday_log(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    }

    $('.range').daterangepicker({
        startDate: start,
        endDate: end,
        "drops": "down",
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    // TOmbol Blast Notif Hari Ini
    $('#btnBlastHariIni').on('click', function () {
        executeBlast($(this));
    });
});

// Tombol Resend pesan ulang tahun by user
$(document).on('click', '.btn-retry', function(e) {
    e.preventDefault();
    
    let btn = $(this);
    let userId = btn.data('employee-id');
    let userName = btn.data('employee-name');

    Swal.fire({
        title: 'Kirim Ulang?',
        html: `Kirim ulang pesan ulang tahun untuk:<br><b class="text-primary">${userName}</b>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            executeResendPerUser(userId, userName, btn);
        }
    });
});

function load_birthday_log(startDate, endDate) {
    var table = $("#dt_birthday_log").DataTable({
        lengthChange: false,
        searching: true,
        destroy: true,
        dom: "Brtip",
        buttons: [{
            extend: 'excelHtml5',
            className: 'btn btn-success btn-sm border-0',
            text: '<i class="bi bi-file-earmark-excel me-1"></i> Export',
            title: 'Log_Birthday_' + startDate
        }],
        ajax: {
            url: "<?= base_url('birthday_monitoring/get_birthday_notif_log') ?>",
            type: "POST",
            data: { start: startDate, end: endDate },
            dataSrc: "data"
        },
        columns: [
            {
                data: "created_at",
                render: d => `<div class="fw-bold">${moment(d).format('DD/MM/YY')}</div><div class="small text-muted">${moment(d).format('HH:mm')}</div>`
            },
            { 
                data: "employee_name", 
                className: "fw-bold text-primary",
                render: function(data, type, row) {
                    if (type === 'display' && data) {
                        return data.toLowerCase().split(' ').map(word => {
                            return word.charAt(0).toUpperCase() + word.slice(1);
                        }).join(' ');
                    }
                    return data;
                }
            },
            { data: "phone", render: d => `<span class="badge bg-light text-dark border font-monospace">${d}</span>` },
            {
                data: "imageUrl",
                render: d => `<a href="${d}" data-fancybox="gallery"><img src="${d}" class="rounded border" width="45" height="30" style="object-fit:cover"></a>`
            },
            {
                data: "status",
                render: function (d) {
                    let color = d === 'success' ? 'bg-success' : 'bg-warning text-dark';
                    return `<span class="badge rounded-pill ${color} px-2" style="font-size: 10px;">${d.toUpperCase()}</span>`;
                }
            },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                    if (data.status === 'success') {
                        return `<span class="text-success small fw-bold"><i class="bi bi-check-circle-fill"></i> Terkirim</span>`;
                    } 
                    
                    return `
                        <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm btn-retry" 
                                data-employee-id="${data.employee_id}"
                                data-employee-name="${data.employee_name}"
                                data-id="${data.id}" 
                                title="Kirim ulang pesan untuk karyawan ini">
                            <i class="bi bi-arrow-clockwise me-1"></i> Resend
                        </button>`;
                }
            }
        ],
        initComplete: function () {
            table.buttons().container().appendTo('#container-buttons');
        }
    });

    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });
}

function executeBlast(btnElement) {
    const tanggalIndo = moment().format('DD MMMM YYYY');

    Swal.fire({
        title: 'Konfirmasi Blast',
        html: `Sistem akan mengirimkan pesan ulang tahun untuk karyawan yang berulang tahun pada:<br><b class="text-primary">Hari ini, ${tanggalIndo}</b>.<br><br>Lanjutkan proses?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim Sekarang!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Loading State
            btnElement.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

            $.ajax({
                url: "<?= base_url('cronjob/birthday_employees/send_birthday_by_date') ?>",
                type: "POST",
                success: function (response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        html: `
                            <div class="text-start p-2">
                                <p class="mb-2">${response}</p>
                                <hr>
                                <div class="alert alert-info border-0 shadow-sm mb-0" style="font-size: 0.9rem;">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <b>Informasi:</b> Antrian pesan telah dibuat. Mohon tunggu beberapa saat hingga server memproses dan pesan masuk ke WhatsApp tujuan.
                                </div>
                            </div>
                        `,
                        icon: 'success'
                    });
                    $('#dt_birthday_log').DataTable().ajax.reload();
                },
                error: function () {
                    Swal.fire('Error!', 'Terjadi kesalahan pada server n8n/database.', 'error');
                },
                complete: function () {
                    btnElement.prop('disabled', false).html('<i class="bi bi-send-fill me-1"></i> Blast Notif Hari Ini');
                }
            });
        }
    });
}

function executeResendPerUser(userId, userName, btnElement) {
    let originalHtml = btnElement.html();
    btnElement.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

    $.ajax({
        url: "<?= base_url('cronjob/birthday_employees/send_birthday_by_user_id/') ?>" + userId,
        type: "GET",
        success: function(response) {
            Swal.fire({
                title: 'Berhasil!',
                html: `
                    <div class="text-center">
                        <p class="mb-2">Berhasil mengirim pesan whatsapp ulang tahun untuk karyawan <br><b>${userName}</b></p>
                        <hr>
                        <div class="small text-muted">
                            <i class="bi bi-info-circle me-1"></i> Pesan sedang diproses oleh server, mohon ditunggu sampai pesan masuk.
                        </div>
                    </div>
                `,
                icon: 'success'
            });
            
            $('#dt_birthday_log').DataTable().ajax.reload(null, false);
        },
        error: function() {
            Swal.fire('Error!', 'Gagal menghubungi server.', 'error');
            btnElement.prop('disabled', false).html(originalHtml);
        }
    });
}
</script>