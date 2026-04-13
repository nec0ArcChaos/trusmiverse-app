
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    function sendMessage()
    {
        var message = $("#message").val();
        var user_id = $("#user_id").val();
        var session_id = $("#session_id").val() || generateSessionId(); // fungsi untuk generate session ID
        var role = "user"; // default role

        if (message.trim() === "") return; // cegah insert kosong

        // tampilkan pesan user langsung
        $("#chat").append(`
            <div class="d-flex justify-content-end mb-3">
                <div class="p-2 rounded-3 bg-light" style="max-width: 80%;">
                    <p class="mb-0 small">${message}</p>
                </div>
            </div>
        `);

        // Tampilkan loading indicator
        $("#chat").append(`
            <div class="d-flex justify-content-start mb-3" id="loading-indicator">
                <div class="p-2 rounded-3 text-white bg-secondary" style="max-width: 80%;">
                    <p class="mb-0 small"><i class="fas fa-spinner fa-spin"></i> Thinking...</p>
                </div>
            </div>
        `);
        $("#chat").scrollTop($("#chat")[0].scrollHeight);

        $.ajax({
            url: "<?= base_url('api/insert_chatbot_hr/save_chatbot_hr') ?>",
            type: "POST",
            data: {
                message: message,
                user_id: user_id,
                session_id: session_id,
                role: role
            },
            dataType: "json",
            success: function(res) {
                // Hapus loading indicator
                $("#loading-indicator").remove();
                
                if(res.status === 'success' && res.jawaban){
                    $("#chat").append(`
                        <div class="d-flex justify-content-start mb-3">
                            <div class="p-2 rounded-3 text-white bg-secondary" style="max-width: 80%;">
                                <p class="mb-0 small">${res.jawaban}</p>
                            </div>
                        </div>
                    `);
                } else {
                    $("#chat").append(`
                        <div class="d-flex justify-content-start mb-3">
                            <div class="p-2 rounded-3 text-white bg-danger" style="max-width: 80%;">
                                <p class="mb-0 small">Error: ${res.jawaban || 'Terjadi kesalahan'}</p>
                            </div>
                        </div>
                    `);
                }
                $("#chat").scrollTop($("#chat")[0].scrollHeight);
            },
            error: function(xhr, status, error) {
                $("#loading-indicator").remove();
                $("#chat").append(`
                    <div class="d-flex justify-content-start mb-3">
                        <div class="p-2 rounded-3 text-white bg-danger" style="max-width: 80%;">
                            <p class="mb-0 small">Error: Terjadi kesalahan koneksi</p>
                        </div>
                    </div>
                `);
                $("#chat").scrollTop($("#chat")[0].scrollHeight);
                console.error("Error:", error, xhr.responseText);
            }
        });

        $("#message").val(""); // kosongkan input
    }

    // Fungsi untuk generate session ID
    function generateSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }


</script>