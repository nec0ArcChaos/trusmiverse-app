<script>
    $('#startSessionBtn').click(function() {
        $('#startSessionModal').modal('show');
        setTimeout(() => {
            document.querySelectorAll('.radio-card').forEach(card => {
                card.classList.add('animate-in');
            });
        }, 350);

        const radioCards = document.querySelectorAll('.radio-card');
        const otherRadio = document.getElementById('topicOtherRadio');
        const otherContainer = document.getElementById('otherTopicContainer');

        // Add click event to all radio cards
        radioCards.forEach(card => {
            const radioInput = card.querySelector('input[type="radio"]');
            if (radioInput) {
                card.addEventListener('click', function() {
                    // Remove selected class from all cards
                    radioCards.forEach(c => {
                        if (c.querySelector('input[type="radio"]')) {
                            c.classList.remove('selected', 'border-blue-500', 'bg-blue-50');
                        }
                    });

                    // Add selected class to clicked card
                    this.classList.add('selected', 'border-blue-500', 'bg-blue-50');

                    // Check the radio input inside
                    radioInput.checked = true;

                    // Show/hide other topic input
                    if (radioInput.value === 'Other') {
                        const otherTopicInput = document.getElementById('otherTopicInput');
                        otherTopicInput.value = '';
                        otherContainer.classList.remove('hidden');
                        otherContainer.style.opacity = '0';
                        otherContainer.style.transform = 'translateY(10px)';

                        setTimeout(() => {
                            otherContainer.style.opacity = '1';
                            otherContainer.style.transform = 'translateY(0)';
                            otherTopicInput.focus();
                        }, 10);
                    } else {
                        otherContainer.classList.add('hidden');
                    }

                    // Show AI confirmation
                    // showAIResponse(`Topik "<strong>${this.querySelector('h3').textContent}</strong>" dipilih. Pilihan yang bagus! Saya akan siapkan materi khusus untuk sesi ini.`);
                });
            }
        });
    });

    $('#startSession').on('click', function(e) {

        // check radio button
        const selectedRadio = document.querySelector('input[name="session_topic"]:checked');
        if (!selectedRadio) {
            $('#alert-start-session').removeClass('hidden');
            $('#alert-start-session').text('Anda belum memilih topik sesi.');
            setTimeout(() => {
                $('#alert-start-session').addClass('hidden');
            }, 2000);
            return;
        }

        $('#startSession').attr('disabled', true);
        $('#startSession').html('<span class="fa fa-spinner fa-spin" role="status" aria-hidden="true"></span> Menyiapkan Sesi...');

        console.log(selectedRadio.value);

        // post ajax
        $.ajax({
            url: '<?= base_url() ?>/ai_counseling/start_session',
            type: 'POST',
            dataType: 'json',
            data: {
                topic: selectedRadio.value
            },
            success: function(response) {

                if (response.status == 'failed') {
                    $('#alert-start-session').removeClass('hidden');
                    $('#alert-start-session').text(response.message);
                    setTimeout(() => {
                        $('#alert-start-session').addClass('hidden');
                    }, 2000);
                }

                $('#startSession').attr('disabled', false);
                $('#startSession').html('Mulai Sesi');
                id_counselling = response.id_coaching;
                window.location.href = '<?= base_url() ?>ai_counseling/session/' + id_counselling;
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    get_last_activity()

    function get_last_activity() {
        const startDate = new Date(Date.now() - (30 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
        const endDate = new Date().toISOString().slice(0, 10);
        $.ajax({
            url: '<?= base_url() ?>ai_counseling/get_last_activity',
            type: 'POST',
            dataType: 'json',
            data: {
                start: startDate,
                end: endDate
            },
            success: function(response) {
                $('#div_last_activity').html('');
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        button_lanjut = `<a href="<?= base_url() ?>ai_counseling/session/${response[index].id_coaching}" class="btn btn-sm btn-primary">${response[index].status == 0 ? 'Lanjutkan' : 'Detail'}</a>`;
                        $('#div_last_activity').append(`<div class="activity-item align-items-center">
                            <div class="activity-icon">
                                <span class="material-symbols-outlined fs-5">history</span>
                            </div>
                            <div class="activity-text col">
                                <h6 style="max-height: 60px;overflow: hidden;text-overflow: ellipsis;">${response[index].review}</h6>
                                <p>${response[index].tanggal}</p>
                            </div>
                            <div class="flex-shrink-0">
                                ${button_lanjut}
                            </div>
                        </div>`);
                    }
                }
            }
        });
    }


    get_sesi_konsultasi()

    function get_sesi_konsultasi() {
        const startDate = new Date(Date.now() - (30 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
        const endDate = new Date().toISOString().slice(0, 10);
        $.ajax({
            url: '<?= base_url() ?>ai_counseling/get_sesi_konsultasi',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#div_sesi_invitation').html('');
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        button_lanjut = `<a href="<?= base_url() ?>ai_counseling/session/${response[index].id_coaching}" class="btn btn-sm btn-primary">${response[index].status == 0 ? 'Lanjutkan' : 'Detail'}</a>`;
                        $('#div_sesi_invitation').append(`<div class="card-session mb-2">
                            <div class="session-content">
                                <div class="session-highlight flex-column flex-md-row">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="session-icon d-none d-md-block">
                                            <span class="material-symbols-outlined fs-5">calendar_month</span>
                                        </div>
                                        <div class="session-info">
                                            <h5>Jadwal Coaching</h5>
                                            <p class="mb-1"><span class="fw-bold">Dari:</span> ${response[index].created_by_name}</p>
                                            <p class="mb-1"><span class="fw-bold">Tanggal:</span> ${response[index].tanggal}</p>
                                            <p class="mb-1"><span class="fw-bold">Review:</span> ${response[index].review}</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 d-block d-md-inline-block">
                                        <a href="<?= base_url() ?>ai_counseling/session/${response[index].id_coaching}" class="btn btn-block d-md-inline-block btn-gradient">Mulai</a>
                                    </div>
                                </div>
                            </div>
                        </div>`);
                    }
                }
            }
        });
    }
</script>