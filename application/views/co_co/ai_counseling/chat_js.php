<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    tailwind.config = {
        darkMode: 'class'
    }
</script>
<script>
    const ID_COUNSELLING = "<?= $counselling['id_coaching'] ?>";
    var LAST_MESSAGE_ID = 0;

    var iMessage = 0;
    var typingTimeoutMessage = null;
    const speedMessage = 80; // milliseconds per word
    var textMessage = "";
    var elementId = "";
    var wordsMessage = [];

    function startTypewriterMessage(elementId, message) {
        stopTypewriterMessage(elementId); // pastikan tidak dobel
        iMessage = 0;
        textMessage = message;

        // Split text menjadi array kata
        wordsMessage = textMessage.split(/(\s+|[\n])/);

        console.log(wordsMessage);

        const el = document.getElementById(elementId);
        console.log(el);
        if (el) el.innerHTML = "";

        typeWriterMessage(elementId);
    }

    function typeWriterMessage(elementId) {
        const el = document.getElementById(elementId);
        console.log(el);
        if (!el) return;

        if (iMessage < wordsMessage.length) {
            const word = wordsMessage[iMessage];

            // Buat span untuk setiap kata dengan animasi fade-in
            const span = document.createElement("span");
            span.innerHTML = word + "&nbsp;";
            span.style.display = "inline-block";
            span.style.animation = "fadeInWord 0.4s ease-in forwards";
            span.style.opacity = "0";

            // Tambahkan style animasi ke head jika belum ada
            if (!document.getElementById("wordAnimationStyle")) {
                const style = document.createElement("style");
                style.id = "wordAnimationStyle";
                style.textContent = `
                @keyframes fadeInWord {
                    from {
                        opacity: 0;
                        transform: translateY(2px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
                document.head.appendChild(style);
            }

            el.appendChild(span);
            iMessage++;
            typingTimeoutMessage = setTimeout(() => {
                typeWriterMessage(elementId);
                console.log(iMessage);
            }, speedMessage);
            // typingTimeoutMessage = setTimeout(typeWriterMessage(elementId), speedMessage);
        }
    }

    function stopTypewriterMessage() {
        clearTimeout(typingTimeoutMessage);
        const el = document.getElementById(elementId);
        if (el) el.innerHTML = "";
    }

    function show_ai_bubble_loader() {
        $('#chat').append(`<div class="flex items-start gap-3 max-w-xl" id="ai-bubble-loader">
                    <div class="flex-shrink-0 size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                        <div class="size-5 text-primary">
                            <img src="<?= base_url() ?>assets/icon/avatar.png" class="img-fluid" alt="" srcset="">
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="p-1 rounded-xl rounded-tl-none bg-slate-100 dark:bg-slate-800" style="max-width: 120px">
                            <p class="text-slate-800 dark:text-slate-200 text-sm"><span class="loader-msg"></span></p>
                        </div>
                    </div>
                </div>`);
    }

    function remove_ai_bubble_loader() {
        $('#ai-bubble-loader').remove();
    }

    function show_user_bubble_loader() {
        $('#chat').append(`<div class="flex items-start gap-3 max-w-xl ml-auto justify-end">
                    <div class="flex-1 text-right">
                        <div class="p-4 rounded-xl rounded-tr-none bg-primary text-white inline-block text-left">
                            <p class="text-sm"><span class="loader-msg"></span></p>
                        </div>
                    </div>
                </div>`);
    }

    function remove_user_bubble_loader() {
        $('#user-bubble-loader').remove();
    }

    function render_ai_bubble(message_id, message, created_at) {
        return `<div class="flex items-start gap-3 max-w-xl">
                    <div class="flex-shrink-0 size-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <div class="size-5 text-primary">
                            <img src="<?= base_url() ?>assets/icon/nira.png" class="img-fluid" alt="" srcset="">
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="p-4 rounded-xl rounded-tl-none bg-slate-100 dark:bg-slate-800">
                            <p class="text-slate-800 dark:text-slate-200 text-sm" id="message_${message_id}">${message}</p>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">${created_at}</p>
                    </div>
                </div>`;
    }

    function render_user_bubble(message_id, message, created_at) {
        return `<div class="flex items-start gap-3 max-w-xl ml-auto justify-end">
                    <div class="flex-1 text-right">
                        <div class="p-4 rounded-xl rounded-tr-none bg-primary text-white inline-block text-left">
                            <p class="text-sm" id="message_${message_id}">${message}</p>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">${created_at}</p>
                    </div>
                </div>`;
    }

    get_coversation();

    function get_coversation() {
        $.ajax({
            url: "<?= base_url() ?>ai_counseling/get_coversation",
            type: "POST",
            dataType: "JSON",
            data: {
                id_coaching: ID_COUNSELLING
            },
            success: function(response) {
                $('#chat').html('');
                if (response.status == 'success') {
                    let data = response.data;
                    for (let i = 0; i < data.length; i++) {
                        message_id = data[i].id;
                        message = data[i].message;
                        created_at = data[i].created_at;
                        type = data[i].sender;
                        LAST_MESSAGE_ID = message_id;
                        if (type == 'user') {
                            $('#chat').append(render_user_bubble(message_id, message, created_at));

                        } else {
                            $('#chat').append(render_ai_bubble(message_id, message, created_at));

                        }
                    }
                }
            }
        });
    }

    $('#btn_send_message').click(function() {
        message = $('#message').val();
        if (message == '') return;
        $('#btn_send_message').prop('disabled', true);
        const now = new Date();
        const formatted_now = now.toISOString().slice(0, 19).replace('T', ' ');
        LAST_MESSAGE_ID = parseInt(LAST_MESSAGE_ID) + 1;
        $('#chat').append(render_user_bubble(LAST_MESSAGE_ID, message, formatted_now));
        show_ai_bubble_loader();
        $('#message').val('');
        $.ajax({
            url: "<?= base_url() ?>ai_counseling/curl_ai_counseling",
            type: "POST",
            dataType: "JSON",
            data: {
                id_counselling: ID_COUNSELLING,
                message: message
            },
            success: function(response) {
                if (response.status == 'success') {
                    remove_ai_bubble_loader();
                    $('#btn_send_message').prop('disabled', false);
                    LAST_MESSAGE_ID = parseInt(LAST_MESSAGE_ID) + 1;
                    created_at = now.toISOString().slice(0, 19).replace('T', ' ');
                    $('#chat').append(render_ai_bubble(LAST_MESSAGE_ID, '', created_at));
                    setTimeout(() => {
                        startTypewriterMessage('message_' + LAST_MESSAGE_ID, response.message);
                    }, 750);
                }
            }
        });
    });

    $('#btn_akhiri_sesi').on('click', function() {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Anda akan mengakhiri sesi ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, akhiri sesi ini'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Loading...',
                    html: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    url: "<?= base_url() ?>ai_counseling/akhiri_sesi",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id_coaching: ID_COUNSELLING
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Anda telah mengakhiri sesi ini',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    }
                });
            }
        });
    });
</script>