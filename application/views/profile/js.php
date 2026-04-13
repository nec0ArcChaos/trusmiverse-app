<script>
    const item_training = function(id_test, training, materi_selesai) {
        if (materi_selesai != 'null' || materi_selesai != null) {
            status_training = `<i class="bi bi-check me-2 text-success"></i>Telah diselesaikan`;
        } else {
            status_training = `<i class="bi bi-clock-history me-2 text-danger"></i>Belum diselesaikan`;
        }
        url_sertifikat = '#';
        return `<div class="col-12 col-md-12 col-lg-12">
                                <div class="card border-0 mb-4">
                                    <div class="card-body">
                                        <div style="padding: 10px;display: flex;justify-content: space-between;">
                                            <div>
                                                <p class="text-secondary small" style="margin-bottom: 0;">${status_training}</p>
                                                <h6>${training}</h6>
                                            </div>
                                            <div>
                                                <a href="${url_sertifikat}" class="btn btn-outline-theme">Lihat Sertifikat</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
    }

    function training_list() {
        user_id = "<?= $this->session->userdata('user_id') ?>";
        $.ajax({
            url: '<?= base_url('profile/training_list') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                list_t = '';
                for (let index = 0; index < response.length; index++) {
                    id_test = response[index].id_test;
                    materi_selesai = response[index].materi_selesai;
                    training = response[index].training;
                    list_t += item_training(id_test, training, materi_selesai);
                }
                $("#training-list").empty();
                $("#training-list").append(list_t);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    training_list();
</script>