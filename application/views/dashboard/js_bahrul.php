<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- app tour script-->
<script src="<?= base_url(); ?>assets/vendor/Product-Tour-jQuery/lib.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    $(document).ready(function () {
        show_dont_dos();
        <?php if (date('m-d', strtotime($personal_info->date_of_birth)) == date('m-d', strtotime(date('Y-m-d')))) { ?>
            show_ultah();
        <?php } ?>
        // $('#chatbot-hr .dropup').show();
        // $('#support-chat').show();
        // $('#support-chat .dropup').show();
        $('#chatbot-hr').show();
        load_chats();
        typeWriterEffect();
    })
</script>
<!-- Test Bubble Start -->
<script>
    const ta = document.getElementById('chatbot-message');

    ta.addEventListener('input', () => {
        ta.style.height = "auto";                 // reset first
        ta.style.height = ta.scrollHeight + "px"; // then fit content
    });
    function timeAgo(dateStr) {
        // Convert string to Date (replace space with 'T' for ISO compliance)
        const past = new Date(dateStr.replace(" ", "T"));
        const now = new Date();

        const diffMs = now - past; // difference in ms
        const diffSec = Math.floor(diffMs / 1000);
        const diffMin = Math.floor(diffSec / 60);
        const diffHr  = Math.floor(diffMin / 60);
        const diffDay = Math.floor(diffHr / 24);

        if (diffSec < 60) return `${diffSec} detik yang lalu`;
        if (diffMin < 60) return `${diffMin} menit yang lalu`;
        if (diffHr < 24) return `${diffHr} jam yang lalu`;
        return `${diffDay} hari yang lalu`;
    }
    function load_chats() {
        $.ajax({
            url: "<?= base_url('chatbot/chatbot_history') ?>",
            type: "get",
            // data: {
            //     message: message,
            //     user_id: user_id,
            //     session_id: session_id,
            //     role: role
            // },
            dataType: "json",
            success: function(res) {
                let chats = res.chats;
                if(chats.length == 0) return;
                let tglchats= []
                let chatList = $("#chatbot-hr .chat-list");
                $(`#last-message`).html(`${timeAgo(chats[chats.length-1].created_at)}`);
                chats.forEach(chat => {
                    let tglchat = new Date(chat.created_at.replace(" ", "T")).toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"});
                    if(!tglchats.includes(tglchat)) {
                        tglchats.push(tglchat);
                        chatList.append(`
                            <div class="row no-margin">
                                <div class="col-12 text-center">
                                    <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3 tglchats">${tglchat}</span>
                                </div>
                            </div>
                        `);
                    }
                    chatList.append(`
                        <div class="row no-margin right-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            ${chat.pertanyaan}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check"></i>${chat.created_at.split(" ")[1].slice(0, 5)}</p>
                            </div>
                        </div>
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            ${chat.jawaban}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check"></i>${chat.created_at.split(" ")[1].slice(0, 5)}</p>
                            </div>
                        </div>
                    `);
                });
                chatList.scrollTop(chatList[chatList.length-1].scrollHeight);
                console.log($(`#chatbot-hr .tglchats`).map(function() { return $(this).text().trim(); }).get());
                
            },
            error: function(xhr, status, error) {
                console.error("Error:", error, xhr.responseText);
            }
        });
    }
    
    $(document).on('shown.bs.dropdown', '#thefirstchat', function () {
        const chatList = $("#chatbot-hr .chat-list");
        if (!chatList) return;
        requestAnimationFrame(() => {
            chatList.scrollTop(chatList[chatList.length-1].scrollHeight);
        });
        bubble.style.display = 'none';
        // bubble.style.opacity = '0';
        // bubble.style.transition = 'opacity 100ms';
        // setTimeout(() => bubble.style.display = 'none', 100);
    });
    


    function sendMessage()
    {
        var message = $("#chatbot-message").val();
        var user_id = <?= $this->session->userdata("user_id") ?>;
        var chatList = $("#chatbot-hr .chat-list");
        var session_id = "<?= $this->session->session_id; ?>"; // fungsi untuk generate session ID
        var role = "user"; // default role

        if (message.trim() === "") return; // cegah insert kosong

        let tglchats = $(`#chatbot-hr .tglchats`).map(function() { return $(this).text().trim(); }).get();
        let tglchat = new Date().toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"});
        if(!tglchats.includes(tglchat)) {
            tglchats.push(tglchat);
            chatList.append(`
                <div class="row no-margin">
                    <div class="col-12 text-center">
                        <span class="alert-warning text-secondary mx-auto btn btn-sm py-1 mb-3 tglchats">${tglchat}</span>
                    </div>
                </div>
            `);
        }
        // tampilkan pesan user langsung
        chatList.append(`
            <div class="row no-margin right-chat">
                <div class="col-12">
                    <div class="chat-block">
                        <div class="row">
                            <div class="col">
                                ${message}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-secondary small time"><i class="bi bi-check"></i>${new Date().toTimeString().slice(0,5)}</p>
                </div>
            </div>
        `);

        // Tampilkan loading indicator
        chatList.append(`
            <div class="row no-margin left-chat" id="loading-indicator">
                <div class="col-12">
                    <div class="chat-block">
                        <div class="row">
                            <div class="col">
                                <i class="fas fa-spinner fa-spin"></i> Thinking...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
        chatList.scrollTop(chatList[chatList.length-1].scrollHeight);
        // Run after the DOM and Bootstrap JS are loaded
        // ['keydown','keypress','keyup','input'].forEach(ev => {
        // document.getElementById('chatbot-message')
        //     ?.addEventListener(ev, e => e.stopPropagation());
        // });
        
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
                    console.log(res);
                    
                    chatList.append(`
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            ${res.jawaban}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check"></i>${res.updated_at.split(" ")[1].slice(0, 5)}</p>
                            </div>
                        </div>
                    `);
                    $(`#last-message`).html(`Baru saja`);
                } else {
                    chatList.append(`
                        <div class="row no-margin left-chat">
                            <div class="col-12">
                                <div class="chat-block">
                                    <div class="row">
                                        <div class="col">
                                            ${res.jawaban || 'Terjadi Kesalahan'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-secondary small time"><i class="bi bi-check"></i>${res.updated_at ? res.updated_at.split(" ")[1].slice(0, 5) : ''}</p>
                            </div>
                        </div>
                    `);
                    $(`#last-message`).html(`Baru saja`);
                }
                chatList.scrollTop(chatList[chatList.length-1].scrollHeight);
            },
            error: function(xhr, status, error) {
                $("#loading-indicator").remove();
                chatList.append(`
                    <div class="row no-margin left-chat">
                        <div class="col-12">
                            <div class="chat-block">
                                <div class="row">
                                    <div class="col">
                                        Error: Terjadi kesalahan koneksi
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                chatList.scrollTop(chatList[chatList.length-1].scrollHeight);
                $(`#last-message`).html(`Baru saja`);
                console.error("Error:", error, xhr.responseText);
            }
        });

        $("#chatbot-message").val(""); // kosongkan input
    }

    // Fungsi untuk generate session ID
    function generateSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    let full_name = "<?= $this->session->userdata('nama'); ?>"
    const bubble = document.getElementById('chatbot-bubble');

    const jikoshoukaiList = [
        "Halo " + full_name + ", senang kenalan denganmu!",
        "Aku adalah partner HR-mu yang selalu siap menjawab pertanyaan soal cuti, izin, jam kerja, sampai aturan kantor.",
        "Panggil aku Laras ! AI HR Asistance ramah yang ngerti banget dunia kerja, tanpa ribet dan selalu kasih info jelas. 🌸🤖",
        "Bersama kita bikin suasana kerja lebih transparan dan nyaman, biar semua tahu hak & kewajiban mereka.",
        "Butuh tahu cara ajukan cuti? Atau aturan lembur? Laras siap kasih jawaban cepat dan enak dibaca. 🕒➡✅",
        "Misi utamaku? Biar kamu nggak perlu bongkar-bongkar aturan HR atau tanya sana-sini. Aku yang bantu, kamu tinggal fokus kerja. 💼✨"
    ];

    let currentText = "";
    let charIndex = 0;
    let jikoIndex = 0;

    let typeTimer = null, holdTimer = null, isTyping = false;

    function typeWriterEffect() {
        const el = document.getElementById("chatbot-bubbleTypewriter");

        if (jikoIndex >= jikoshoukaiList.length) { /* fade out... */ return; }

        // mulai kalimat baru
        if (!isTyping && charIndex === 0) el.textContent = "";

        isTyping = true;
        if (typeTimer) clearTimeout(typeTimer);
        typeTimer = setTimeout(() => {
            currentText += jikoshoukaiList[jikoIndex].charAt(charIndex);
            el.textContent = currentText;
            charIndex++;

            if (charIndex < jikoshoukaiList[jikoIndex].length) {
                typeWriterEffect();
            } else {
                isTyping = false;
                // jeda baca
                if (holdTimer) clearTimeout(holdTimer);
                holdTimer = setTimeout(() => {
                    jikoIndex++;            // naik SETELAH selesai render
                    currentText = "";
                    charIndex = 0;
                    typeWriterEffect();
                    if (jikoIndex >= jikoshoukaiList.length) {
                        // Fade out lalu remove
                        bubble.style.transition = 'opacity 500ms';
                        bubble.style.opacity = '0';
                        bubble.style.pointerEvents = 'none';
                        bubble.addEventListener('transitionend', () => bubble.remove(), { once: true });
                        return;
                    }
                }, 1500);
            }
        }, 40);
        
    }
    // function typeWriterEffect() {
    //     if (jikoIndex < jikoshoukaiList.length) {
    //         if (charIndex < jikoshoukaiList[jikoIndex].length) {
    //             currentText += jikoshoukaiList[jikoIndex].charAt(charIndex);
    //             document.getElementById("bubbleTypewriter").innerHTML = currentText;
    //             charIndex++;
    //             setTimeout(typeWriterEffect, 40);
    //         } else {
    //             setTimeout(() => {
    //                 jikoIndex++;
    //                 console.log(jikoIndex);

    //                 if (jikoIndex < jikoshoukaiList.length) {
    //                     currentText = "";
    //                     charIndex = 0;
    //                     typeWriterEffect();
    //                 } else {
    //                     bubble.style.opacity = '0';
    //                     bubble.style.transition = 'opacity 500ms';
    //                     setTimeout(() => bubble.style.display = 'none', 500);
    //                 }
    //             }, 1500);
    //         }
    //     }
    // }

    window.onload = typeWriterEffect;
</script>
<script>
    // Sample data (in real app, populate from API)
    // let recentMatches = [];

    // const panel = document.getElementById('panel');
    // const avatarBtn = document.getElementById('avatarBtn');
    // const panelItems = document.getElementById('panelItems');
    // const lastScanEl = document.getElementById('lastScan');
    // const countScreened = document.getElementById('countScreened');

    // // Initialize panel content
    // function renderPanel() {
    //     $.ajax({
    //         url: "<?= base_url('recruitment/job_candidates/summary_ella') ?>",
    //         method: "POST",
    //         dataType: "JSON",
    //         dataType: "JSON",
    //         success: function (res) {
    //             countScreened.innerHTML = res.summary.total_screened;
    //             lastScanEl.innerHTML = res.summary.last_screened ? res.summary.last_screened : 'N/A';
    //             recentMatches.length = 0;
    //             recentMatches.push(...res.top_candidate);
    //             panelItems.innerHTML = '';
    //             recentMatches.forEach(m => {
    //                 const item = document.createElement('div');
    //                 item.className = 'item';
    //                 item.innerHTML = '<div style="display:flex;justify-content:space-between;align-items:center"><div><strong>' + escapeHtml(m.full_name) + '</strong><div class="muted" style="font-size:12px">' + escapeHtml(m.job_title) + '</div></div><div style="text-align:right"><strong>' + m.matching_total_score + '%</strong><div class="muted" style="font-size:12px">' + escapeHtml(m.status_score) + '</div></div></div>';
    //                 panelItems.appendChild(item);
    //             });
    //         }
    //     });
    // }

    // // Simple escape
    // function escapeHtml(s) {
    //     return ('' + s).replace(/[&<>"'\/]/g, function (c) {
    //         return {
    //             '&': '&amp;',
    //             '<': '&lt;',
    //             '>': '&gt;',
    //             '"': '&quot;',
    //             "'": '&#39;',
    //             '/': '&#47;'
    //         }[c];
    //     });
    // }

    // // show panel when avatar clicked
    // avatarBtn.addEventListener('click', function () {
    //     if (panel.style.display === 'block') {
    //         panel.style.display = 'none';
    //     } else {
    //         renderPanel();
    //         panel.style.display = 'block';
    //     }
    //     // hide bubble after first interaction
    //     bubble.style.display = 'none';
    // });

    // // close button
    // // document.getElementById('btnClosePanel').addEventListener('click', function() {
    // //     panel.style.display = 'none';
    // // });

    // // actions
    // // document.getElementById('btnViewReports').addEventListener('click', function() {
    // //     alert('Open reports page (implement your routing).');
    // // });
    // // document.getElementById('btnRunScan').addEventListener('click', function() {
    // //     // simulate quick scan
    // //     this.disabled = true;
    // //     this.textContent = 'Scanning...';
    // //     setTimeout(() => {
    // //         // update sample data
    // //         recentMatches.unshift({
    // //             name: 'New Candidate',
    // //             role: 'Design Engineer',
    // //             fit: 77,
    // //             note: 'Good CAD skills, lacks field experience.'
    // //         });
    // //         if (recentMatches.length > 6) recentMatches.pop();
    // //         renderPanel();
    // //         document.getElementById('statScanned').textContent = Number(document.getElementById('statScanned').textContent) + 4;
    // //         document.getElementById('countScreened').textContent = Number(document.getElementById('countScreened').textContent) + 4;
    // //         lastScanEl.textContent = 'just now';
    // //         this.disabled = false;
    // //         this.textContent = 'Run quick scan';
    // //     }, 1400);
    // // });

    // // initial bubble auto-hide after 4s
    // setTimeout(() => {
    //     bubble.style.opacity = '0';
    //     bubble.style.transition = 'opacity 500ms';
    //     setTimeout(() => bubble.style.display = 'none', 500);
    // }, 60000);

    // // keyboard accessibility: press E to toggle panel
    // document.addEventListener('keydown', function (e) {
    //     if (e.key.toLowerCase() === 'e') {
    //         avatarBtn.click();
    //     }
    // });

    // // initial render
    // renderPanel();

    // // // simulate background updates (for demo)
    // // setInterval(() => {
    // //     // randomly update some stats
    // //     const scanned = Number(document.getElementById('statScanned').textContent) + (Math.random() > 0.7 ? 1 : 0);
    // //     document.getElementById('statScanned').textContent = scanned;
    // //     // update avg
    // //     document.getElementById('statAvg').textContent = Math.max(60, Math.round((Math.random() * 30) + 60)) + '%';
    // // }, 5000);



    // $('#btn_re_scan_candidate').on('click', function () {
    //     let application_id = $('#job_id').val();
    //     $.ajax({
    //         url: "https://n8n.trustcore.id/webhook/0d32da51-4ee6-4801-8308-99560677a461",
    //         method: "POST",
    //         data: {
    //             application_id: application_id
    //         },
    //         dataType: "JSON",
    //         beforeSend: function () {
    //             $('#btn_re_scan_candidate').text('Scanning...');
    //             $('#btn_re_scan_candidate').attr('disabled', true);
    //         },
    //         success: function (res) {
    //             success_alert('Scan ulang berhasil dijalankan, tunggu beberapa 1-2 menit saat lagi untuk melihat hasilnya');
    //             $('#modal_edit_status').modal('hide');
    //             $('#btn_re_scan_candidate').removeAttr('disabled');
    //             $('#btn_re_scan_candidate').text('Scan Ulang');
    //         },
    //         error: function (res) {
    //             console.log(res.responseText);
    //         }
    //     })
    // });
</script>
<!-- Test Bubble End -->

<script>
    $(".tgl").mask('0000-00-00');
    // Running Datepicker
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    function animateValue(id, start, end, duration) {
        // assumes integer values for start and end

        $('#' + id).empty();
        var obj = document.getElementById(id);
        var range = end - start;
        // no timer shorter than 50ms (not really visible any way)
        var minTimer = 50;
        // calc step time to show all interediate values
        var stepTime = Math.abs(Math.floor(duration / range));

        // never go below minTimer
        stepTime = Math.max(stepTime, minTimer);

        // get current time and calculate desired end time
        var startTime = new Date().getTime();
        var endTime = startTime + duration;
        var timer;

        function run() {
            var now = new Date().getTime();
            var remaining = Math.max((endTime - now) / duration, 0);
            var value = Math.round(end - (remaining * range));
            obj.innerHTML = value;
            if (value == end) {
                clearInterval(timer);
            }
        }

        timer = setInterval(run, stepTime);
        run();
    }


    function temporary_change_profile_background(image_name) {
        $('#coverimg_div').css('background-image', `url('<?= base_url(); ?>assets/img/${image_name}')`);
        $('#coverimg').attr('src', '<?= base_url(); ?>assets/img/${image_name}');
        $('#u_profile_background').val(image_name);
    }

    $('#btn_update_personal_info').on("click", function () {
        let u_contact_no = $("#u_contact_no").val();
        let u_email = $("#u_email").val();
        let u_email_corporate = $("#u_email_corporate").val();
        let u_date_of_birth = $("#u_date_of_birth").val();
        let u_gender = $("#u_gender").val();

        if (u_contact_no == "") {
            alertInput('Anda belum mengisi nomor contact');
            return false;
        }

        if (u_email == "") {
            alertInput('Anda belum mengisi email');
            return false;
        }

        if (u_email_corporate == "") {
            alertInput('Anda belum mengisi email corporate');
            return false;
        }

        if (u_date_of_birth == "") {
            alertInput('Anda belum mengisi tgl lahir');
            return false;
        }

        if (u_gender == "") {
            alertInput('Anda belum memilih gender');
            return false;
        }

        if (u_contact_no && u_email && u_date_of_birth && u_gender) {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    $.ajax({
                        url: `<?= base_url() ?>dashboard/update_personal_info`,
                        data: {
                            contact_no: u_contact_no,
                            email: u_email,
                            email_corporate: u_email_corporate,
                            date_of_birth: u_date_of_birth,
                            gender: u_gender
                        }, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        console.log(response.status);
                        if (response.status == 'success') {
                            $('#modal_change_personal_info').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Berhasil, mengubah profile info',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);

                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            $('#modal_change_personal_info').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Failed!' + textStatus,
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }
    });


    function alertInput(msg) {
        $.confirm({
            icon: 'fa fa-close',
            title: 'Oops!',
            theme: 'material',
            type: 'red',
            animation: 'RotateXR',
            closeAnimation: 'RotateXR',
            animateFromElement: false,
            content: msg,
            buttons: {
                close: {
                    actions: function () { }
                },
            },
        });
    }

    $('#btn_update_profile_background').on("click", function () {
        let u_profile_background = $("#u_profile_background").val();
        if (u_profile_background == "") {
            alertInput('Anda belum memilih foto latar belakang');
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    $.ajax({
                        url: `<?= base_url() ?>dashboard/update_profile_background`,
                        data: {
                            profile_background: u_profile_background
                        }, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        console.log(response.status);
                        if (response.status == 'success') {
                            $('#modal_change_profile_background').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Berhasil, mengubah foto cover',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        } else {
                            $('#modal_change_profile_background').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Failed!' + textStatus,
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    });

    $('#btn_upload_profile_picture').on("click", function () {
        let u_profile_picture = $("#u_profile_picture")[0].files.length;
        if (u_profile_picture === 0) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Anda belum memilih foto',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    let f_profile_picture = $("#u_profile_picture").prop("files")[0];
                    let form_data_profile_picture = new FormData();
                    form_data_profile_picture.append("profile_picture", f_profile_picture);
                    $.ajax({
                        url: `<?= base_url() ?>dashboard/update_profile_picture`,
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data_profile_picture, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        console.log(response.status);
                        if (response.status == 'success') {
                            $('#modal_change_profile_picture').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Berhasil, mengubah foto profile',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);

                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            $('#modal_change_profile_picture').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Failed!' + textStatus,
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    });


    $('#btn_upload_ttd').on("click", function () {
        let u_ttd = $("#u_ttd")[0].files.length;
        if (u_ttd === 0) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Anda belum memilih foto',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    let f_ttd = $("#u_ttd").prop("files")[0];
                    let form_data_ttd = new FormData();
                    form_data_ttd.append("ttd", f_ttd);
                    $.ajax({
                        url: `<?= base_url() ?>dashboard/update_ttd`,
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data_ttd, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        console.log(response.status);
                        if (response.status == 'success') {
                            $('#modal_change_ttd').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Berhasil, mengubah tanda tangan',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);

                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            $('#modal_change_ttd').modal('hide');
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Failed!' + textStatus,
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    });

    resume_absen('<?= date("Y-m") ?>', '<?= $this->session->userdata("user_id"); ?>', '<?= $this->session->userdata("cutoff"); ?>');
    detail_absen('<?= date("Y-m") ?>', '<?= $this->session->userdata("user_id"); ?>', '<?= $this->session->userdata("cutoff"); ?>');


    // addnew cutoff
    function resume_absen(periode, employee_id, cutoff) {
        $.ajax({
            url: '<?= base_url('dashboard/resume_absen') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                periode: periode,
                employee_id: employee_id,
                cutoff: cutoff
            },
            beforeSend: function () {

            },
            success: function (response) {
                console.log('Resume Absen: ', response);

                animateValue("harus_hadir", 0, response.total_hadir.harus_hadir ?? 0, 3000);
                animateValue("present", 0, response.total_hadir.total_hadir, 3000);
                animateValue("bolos", 0, response.data.bolos, 3000);
                animateValue("leave", 0, (parseInt(response.data.total_cuti_khusus) + parseInt(response.data
                    .total_dinas) + parseInt(response.data.total_sakit)), 3000);
                animateValue("warning", 0, response.total_warning, 3000);
                animateValue("late", 0, response.data.menit_telat, 3000);

                kehadiran = (response.total_hadir.harus_hadir < 1) ? 0 : Math.round((response.data.total_hadir /
                    response.total_hadir.harus_hadir) * 100) / 100;
                kedisiplinan = (response.total_hadir.harus_hadir < 1) ? 0 : Math.round(((response.data
                    .total_hadir - response.data.telat - response.data.bolos - response.data
                        .total_izin_pc_dt - response.data.absen_sekali) / response.total_hadir
                        .harus_hadir) * 100) / 100;
                animateValue("kehadiran", 0, kehadiran * 100, 3000);
                animateValue("kedisiplinan", 0, kedisiplinan * 100, 3000);
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    get_personal_detail()

    function get_personal_detail() {
        $.ajax({
            url: '<?= base_url() ?>dashboard/get_personal_detail',
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: '<?= $this->session->userdata('user_id') ?>'
            },
            beforeSend: function () {

            },
            success: function (response) {
                console.log(response)
                $('#d_company').text(response.company_name)
                $('#d_employee_name').text(response.employee_name)
                $('#d_jabatan').text(response.department_name + ' | ' + response.designation_name)

                $('#p_fullname').text(response.employee_name)
                $('#p_company_name').text(response.company_name)
                $('#p_department_name').text(response.department_name)
                $('#p_designation_name').text(response.designation_name)
                $('#p_employee_id').text(response.employee_id)
                $('#p_contact_no').text(response.contact_no)
                $('#p_email').text(response.email)
                $('#p_date_of_joining').text(response.date_of_joining)
                $('#p_username').text(response.username)
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    let options = {
        searchable: true
    }
    let n_month = NiceSelect.bind(document.getElementById('month'), options);
    let n_year = NiceSelect.bind(document.getElementById('year'), options);
    let n_employee_id = NiceSelect.bind(document.getElementById('employee_id'), options);
    let n_month_history = NiceSelect.bind(document.getElementById('month-history'), options);
    let n_year_history = NiceSelect.bind(document.getElementById('year-history'), options);
    let n_month_leave = NiceSelect.bind(document.getElementById('month-leave'), options);
    let n_year_leave = NiceSelect.bind(document.getElementById('year-leave'), options);

    let n_cutoff = NiceSelect.bind(document.getElementById('cutoff'), options); // addnew

    get_employee_id();

    function get_employee_id() {
        user_id = "<?= $this->session->userdata('user_id'); ?>"
        $.ajax({
            url: '<?= base_url() ?>dashboard/get_employee_id',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                // console.log(response);
                list_employee = '';
                for (let index = 0; index < response.length; index++) {
                    list_employee +=
                        `<option value="${response[index].user_id}" ${user_id == response[index].user_id ? 'selected' : ''}>${response[index].employee_name}</option>`;
                }

                $("#employee_id").empty().append(list_employee);
                n_employee_id.update()

            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    function filter_detail() {
        periode = $("#year").val() + '-' + $("#month").val();
        cutoff = $("#cutoff").val(); // addnew
        employee_id = $("#employee_id").val();
        // console.log(periode);
        // console.log('Cutoff : ', cutoff);
        console.log('Employee_id : ', employee_id);
        resume_absen(periode, employee_id, cutoff)
        detail_absen(periode, employee_id, cutoff)
    }

    function detail_absen(periode, employee_id, cutoff) { // addnew cutoff detdev
        $.ajax({
            url: '<?= base_url('dashboard/detail_absen') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                periode: periode,
                employee_id: employee_id,
                cutoff: cutoff
            },
            beforeSend: function () {

            },
            success: function (response) {
                // console.log(response);
                item_detail_absen = ``;
                for (let index = 0; index < response.data.length; index++) {

                    if (response.data[index].photo_in != null) {
                        photo_in = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${response.data[index].photo_in}">
                        <figure class="avatar avatar-20 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr_upload/${response.data[index].photo_in}&quot;);">
                            <img src="https://trusmiverse.com/hr_upload/${response.data[index].photo_in}" alt="" id="userphotoonboarding2" style="display: none;">
                        </figure></a>`;
                    } else {
                        photo_in = '<h5 class="fw-medium small">No Photo<small></small></h5>';
                    }
                    if (response.data[index].photo_out != null) {
                        photo_out = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${response.data[index].photo_out}">
                        <figure class="avatar avatar-20 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr_upload/${response.data[index].photo_out}&quot;);">
                            <img src="https://trusmiverse.com/hr_upload/${response.data[index].photo_out}" alt="" id="userphotoonboarding2" style="display: none;">
                        </figure></a>`;
                    } else {
                        photo_out = '<h5 class="fw-medium small">No Photo<small></small></h5>';
                    }

                    border_late = '';
                    if (response.data[index].diff_in > 0 || response.data[index].diff_out < 0) {
                        border_late = 'border-late';
                    }
                    late = '';
                    if (response.data[index].diff_in > 0) {
                        late = `(Late ${response.data[index].diff_in} mnt)`;
                    }
                    pulang = '';
                    if (response.data[index].diff_out < 0) {
                        pulang = `(Early ${response.data[index].diff_out} mnt)`;
                    }
                    if (response.data[index].diff_out > 0) {
                        pulang = `(Over ${response.data[index].diff_out} mnt)`;
                    }

                    let shift_comp = '';
                    if (response.data[index].office_shift_id != '1165') {
                        shift_comp =
                            `<p class="text-dark small mb-1 col-12 col-md-6">Shift : <span>${response.data[index].shift_in}</span> s/d <span>${response.data[index].shift_out}</span> </p>`;
                    }
                    item_detail_absen += `
                        <div class="card mb-1 mt-1">
                            <div class="card-body ${border_late}">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressblue"></div>
                                            <div class="avatar h5 bg-light-blue rounded-circle">
                                                <i class="bi bi-calendar2-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <p class="text-dark small mb-1 col-12 col-md-6" style="font-weight: bold;">Tgl : ${response.data[index].attendance_date}</p>
                                            ${shift_comp}
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Clock In</p>
                                                <h5 class="fw-medium small">${response.data[index].clock_in}<small> ${late}</small></h5>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Photo In</p>
                                                ${photo_in}
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Clock Out</p>
                                                <h5 class="fw-medium small">${response.data[index].clock_out ?? '-'}<small> ${pulang}</small></h5>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Photo Out</p>
                                                ${photo_out}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                }
                $("#body_detail_absen").empty().append(item_detail_absen);
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    get_rekening()

    function get_rekening() {
        $.ajax({
            url: '<?= base_url() ?>dashboard/get_rekening',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                $('#p_account_number').html(response.account_number);
                $('#p_account_title').html(response.account_title);
                $('#p_bank_name').html(response.bank_name);
                $('#p_created_at').html(response.created_at);
                $('#account_number').val(response.account_number);
                $('#account_title').val(response.account_title);
                $('#bank_name').val(response.bank_name).trigger("chosen:updated");

                if (response.bank_name == "Bank CIMB Niaga") {
                    $("#atm-card").addClass('theme-red')
                    $("#atm-card-2").addClass('theme-blue')
                } else if (response.bank_name == "Bank Danamon") {
                    $("#atm-card").addClass('theme-yellow')
                    $("#atm-card-2").addClass('theme-blue')
                } else if (response.bank_name == "Bank Permata") {
                    $("#atm-card").addClass('theme-green')
                    $("#atm-card-2").addClass('theme-blue')
                } else {
                    $("#atm-card").addClass('theme-blue')
                    $("#atm-card-2").addClass('theme-pink')
                }
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    $('#btn_update_password').on('click', function () {
        var old_password = $('#old_password').val();
        var new_password = $('#new_password').val();
        if (!old_password) {
            $.alert({
                title: 'Alert!',
                content: 'Old Password Tidak Boleh Kosong!',
            });
            return false;
        }
        if (!new_password) {
            $.alert({
                title: 'Alert!',
                content: 'New Password Tidak Boleh Kosong!',
            });
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>dashboard/update_password',
            type: 'POST',
            dataType: 'json',
            data: {
                old_password: old_password,
                new_password: new_password,
            },
            beforeSend: function () {
                $.confirm({
                    icon: 'fa fa-spinner fa-spin',
                    title: 'Mohon Tunggu!',
                    theme: 'material',
                    type: 'blue',
                    content: 'Kami sedang memproses permintaan Anda!',
                    buttons: {
                        close: {
                            isHidden: true,
                            actions: function () { }
                        },
                    },
                });
            },
            success: function (response) {
                setTimeout(() => {
                    jconfirm.instances[0].close();
                    if (response.status == 'success') {
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Done!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Terima kasih sudah menunggu!',
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                        $('#modal_change_password').modal('hide');

                        setTimeout(() => {
                            window.location.href = '<?= base_url() ?>login/logout';
                        }, 500);
                    } else {
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Gagal!',
                            theme: 'supervan',
                            type: 'red',
                            content: response.msg,
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                    }
                }, 250);
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    });
    $('#btn_update_ctm_pin_slip').on('click', function () {
        var old_ctm_pin_slip = $('#old_ctm_pin_slip').val();
        var new_ctm_pin_slip = $('#new_ctm_pin_slip').val();
        if (!old_ctm_pin_slip) {
            $.alert({
                title: 'Alert!',
                content: 'Pin Tidak Boleh Kosong!',
            });
            return false;
        }
        if (!new_ctm_pin_slip) {
            $.alert({
                title: 'Alert!',
                content: 'Pin Tidak Boleh Kosong!',
            });
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>dashboard/update_ctm_slip',
            type: 'POST',
            dataType: 'json',
            data: {
                old_ctm_pin_slip: old_ctm_pin_slip,
                new_ctm_pin_slip: new_ctm_pin_slip,
            },
            beforeSend: function () {
                $.confirm({
                    icon: 'fa fa-spinner fa-spin',
                    title: 'Mohon Tunggu!',
                    theme: 'material',
                    type: 'blue',
                    content: 'Kami sedang memproses permintaan Anda!',
                    buttons: {
                        close: {
                            isHidden: true,
                            actions: function () { }
                        },
                    },
                });
            },
            success: function (response) {
                setTimeout(() => {
                    jconfirm.instances[0].close();
                    if (response.status == 'success') {
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Done!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Terima kasih sudah menunggu!',
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                        $('#modal_change_pin_slip').modal('hide');

                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        $.confirm({
                            icon: 'fa fa-x',
                            title: 'Gagal!',
                            theme: 'supervan',
                            type: 'red',
                            content: response.msg,
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                    }
                }, 250);
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    });

    $('#btn-update-rekening').on('click', function () {
        var account_title = $('#account_title').val();
        var account_number = $('#account_number').val();
        var bank_name = $('#bank_name').val();
        if (!bank_name) {
            $.alert({
                title: 'Alert!',
                content: 'Nama Bank Tidak Boleh Kosong!',
            });
            return false;
        }
        if (!account_number) {
            $.alert({
                title: 'Alert!',
                content: 'Nomor Rekening Tidak Boleh Kosong!',
            });
            return false;
        }
        if (!account_title) {
            $.alert({
                title: 'Alert!',
                content: 'Nama Pemegang Buku Rekening Tidak Boleh Kosong!',
            });
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>dashboard/update_rekening',
            type: 'POST',
            dataType: 'json',
            data: {
                account_title: account_title,
                account_number: account_number,
                bank_name: bank_name,
            },
            beforeSend: function () {
                $.confirm({
                    icon: 'fa fa-spinner fa-spin',
                    title: 'Mohon Tunggu!',
                    theme: 'material',
                    type: 'blue',
                    content: 'Kami sedang memproses permintaan Anda!',
                    buttons: {
                        close: {
                            isHidden: true,
                            actions: function () { }
                        },
                    },
                });
            },
            success: function (response) {
                get_rekening();
                setTimeout(() => {
                    jconfirm.instances[0].close();
                    if (response.status == true) {
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Done!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Terima kasih sudah menunggu!',
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                        $('#modal_change_rekening').modal('hide');
                    } else {
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Gagal!',
                            theme: 'supervan',
                            type: 'red',
                            content: 'Silahkan coba beberapa saat lagi!',
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                    }
                }, 250);
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    });

    $('#btn_e_training').on('click', function () {
        $('#container_personal_details').fadeOut();
        $('#container_manage_leave').fadeOut();
        $('#container_history_warning').fadeOut();
        $('#container_e_training').fadeIn();
        $('#btn_personal_details').removeClass('active-4');
        $('#btn_manage_leave').removeClass('active-4');
        $('#btn_history_warning').removeClass('active-4');
        $('#btn_e_training').addClass('active-4');
    });
    $('#container_e_training').hide();

    $('#btn_history_warning').on('click', function () {
        $('#container_personal_details').fadeOut();
        $('#container_manage_leave').fadeOut();
        $('#container_e_training').fadeOut();
        $('#container_history_warning').fadeIn();
        $('#btn_personal_details').removeClass('active-4');
        $('#btn_manage_leave').removeClass('active-4');
        $('#btn_history_warning').addClass('active-4');
        $('#btn_e_training').removeClass('active-4');
    });
    $('#container_history_warning').hide();


    $('#btn_manage_leave').on('click', function () {
        $('#container_personal_details').fadeOut();
        $('#container_history_warning').fadeOut();
        $('#container_e_training').fadeOut();
        $('#container_manage_leave').fadeIn();
        $('#btn_personal_details').removeClass('active-4');
        $('#btn_history_warning').removeClass('active-4');
        $('#btn_manage_leave').addClass('active-4');
        $('#btn_e_training').removeClass('active-4');
    });
    $('#container_manage_leave').hide();


    $('#btn_personal_details').on('click', function () {
        $('#container_personal_details').fadeIn();
        $('#container_manage_leave').fadeOut();
        $('#container_e_training').fadeOut();
        $('#container_history_warning').fadeOut();
        $('#btn_personal_details').addClass('active-4');
        $('#btn_manage_leave').removeClass('active-4');
        $('#btn_history_warning').removeClass('active-4');
        $('#btn_e_training').removeClass('active-4');
    });

    leave_categories()

    function leave_categories() {
        $.ajax({
            url: '<?= base_url() ?>dashboard/leave_categories',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                console.log(response);
                item_categories_leave = '';
                for (let index = 0; index < response.length; index++) {
                    if (response[index].is_allowed == 1) {
                        icon_leave = 'bi bi-check-circle text-success';
                        text_item = `${response[index].type_name}`;
                    } else {
                        icon_leave = 'bi bi-x-lg text-danger';
                        text_item =
                            `<span style="text-decoration: line-through">${response[index].type_name}</span>`;
                    }
                    item_categories_leave += `<li class="list-group-item ">
                                                    <div class="row">
                                                        <div class="col-2 col-sm-2">
                                                            <i class="${icon_leave}"></i>
                                                        </div>
                                                        <div class="col-10 col-sm-10 ps-0">
                                                            ${text_item}
                                                        </div>
                                                    </div>
                                                </li>`
                }
                $('#content_leave_categories').empty().append(item_categories_leave);
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    function filter_history_warning() {
        periode = $("#year-history").val() + '-' + $("#month-history").val();
        history_warning(periode);

    }

    history_warning('<?= date("Y-m") ?>');

    function history_warning(periode) {
        $.ajax({
            url: '<?= base_url() ?>dashboard/history_warning',
            type: 'POST',
            dataType: 'json',
            data: {
                periode: periode
            },
            beforeSend: function () {

            },
            success: function (response) {
                console.log(response);
                item_history_warning = `<li class="list-group-item ">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-2">
                                                            <b>Tgl</b>
                                                        </div>
                                                        <div class="col-12 col-sm-2">
                                                            <b>Jam</b>
                                                        </div>
                                                        <div class="col-12 col-sm-8">
                                                            <b>Keterangan</b>
                                                        </div>
                                                    </div>
                                                </li>`;
                if (response.length > 1) {
                    for (let index = 0; index < response.length; index++) {
                        item_history_warning += `<li class="list-group-item ">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-2">
                                                            ${response[index].tgl_warning}
                                                        </div>
                                                        <div class="col-12 col-sm-2">
                                                            ${response[index].jam_warning}
                                                        </div>
                                                        <div class="col-12 col-sm-8">
                                                            <p>${response[index].reason}</p>
                                                        </div>
                                                    </div>
                                                </li>`
                    }
                    $('#content_history_warning').empty().append(item_history_warning);
                } else {
                    item_history_warning = `<li class="list-group-item ">
                                                    <div class="row">
                                                        <div class="col-auto ps-0 text-center">
                                                            No Data
                                                        </div>
                                                    </div>
                                                </li>`
                    $('#content_history_warning').empty().append(item_history_warning);
                }
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }




    function filter_manage_leave() {
        periode = $("#year-leave").val() + '-' + $("#month-leave").val();
        manage_leave(periode);
    }

    manage_leave('<?= date("Y-m") ?>');

    function manage_leave(periode) {
        $.ajax({
            url: '<?= base_url() ?>dashboard/manage_leave',
            type: 'POST',
            dataType: 'json',
            data: {
                periode: periode
            },
            beforeSend: function () {

            },
            success: function (response) {
                console.log(response);
                item_manage_leave = `<li class="list-group-item ">
                                        <div class="row">
                                            <div class="col-6 col-sm-2">
                                                <b>From</b>
                                            </div>
                                            <div class="col-6 col-sm-2">
                                                <b>To</b>
                                            </div>
                                            <div class="col-12 col-sm-8">
                                                <b>Keterangan</b>
                                            </div>
                                        </div>
                                    </li>`;
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        item_manage_leave += `<li class="list-group-item ">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-2">
                                                            ${response[index].from_date}
                                                        </div>
                                                        <div class="col-6 col-sm-2">
                                                            ${response[index].to_date}
                                                        </div>
                                                        <div class="col-12 col-sm-8">
                                                            <p>${response[index].type_name}</p>
                                                        </div>
                                                    </div>
                                                </li>`
                    }
                    $('#content_manage_leave').empty().append(item_manage_leave);
                } else {
                    item_manage_leave = `<li class="list-group-item ">
                                                    <div class="row">
                                                        <div class="col-auto ps-0 text-center">
                                                            No Data
                                                        </div>
                                                    </div>
                                                </li>`
                    $('#content_manage_leave').empty().append(item_manage_leave);
                }
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    function add_manage_leave() {
        $.confirm({
            title: 'Add Manage Leave',
            type: 'blue',
            theme: 'material',
            columnClass: 'col-12 col-md-8 col-lg-8',
            content: function () {
                var self = this;
                return $.ajax({
                    url: '<?= base_url() ?>dashboard/get_leave_type',
                    dataType: 'json',
                    method: 'POST',
                }).done(function (response) {
                    opt_leave_type = '';
                    for (let index = 0; index < response.leave_type.length; index++) {
                        opt_leave_type +=
                            `<option value="${response.leave_type[index].leave_type_id}" data-warning="${response.leave_type[index].warning}">${response.leave_type[index].type_name} (${response.leave_type[index].sisa_izin} Remaining)</option>`
                    }
                    opt_kota = '<option value="">Pilih Kota</option>';
                    for (let index = 0; index < response.kota.length; index++) {
                        opt_kota +=
                            `<option value="${response.kota[index].id}">${response.kota[index].city}, ${response.kota[index].state}</option>`
                    }
                    self.setContent(`
                    <form action="" id="form-add-leave" class="formName" enctype="multipart/form-data" style="min-height:500px;">
                        <div class="row align-items-center m-1">
                            <div class="mb-3 col-12">
                                <label for="leave_type" class="form-label-custom required">Leave Type</label>
                                <select id="leave_type" name="leave_type" class="wide mb-3 leave_type">
                                    ${opt_leave_type}
                                </select>
                            </div>
                            <div class="mb-3 col-12" id="div_kota">
                                <label for="kota" class="form-label-custom required">Leave Type</label>
                                <select id="kota" name="kota" class="wide mb-3 kota">
                                    ${opt_kota}
                                </select>
                            </div>
                            <div class="mb-3 col-6 col-md-6 col-lg-6" id="div_tgl_ph">
                                <label for="tgl_ph" class="form-label-custom required">Pilih Tgl Libur</label>
                                <input type="text" class="form-control border-custom tgl tanggal" name="tgl_ph" id="tgl_ph" aria-describedby="tgl_ph" placeholder="yyyy-mm-dd">
                            </div>
                            <div class="mb-3 col-6 col-md-6 col-lg-6">
                                <label for="start_date" class="form-label-custom required" id="label_start_date">Start Date</label>
                                <input type="text" class="form-control border-custom tgl tanggal" name="start_date" id="start_date" aria-describedby="start_date" placeholder="yyyy-mm-dd">
                            </div>
                            <div class="mb-3 col-6 col-md-6 col-lg-6" id="div_tgl_ph_end_date">
                                <label for="end_date" class="form-label-custom required">End Date</label>
                                <input type="text" class="form-control border-custom tgl tanggal" name="end_date" id="end_date" aria-describedby="end_date" placeholder="yyyy-mm-dd">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="attachment" class="form-label-custom required">Attachment</label>
                                <input type="file" class="form-control border-custom" name="attachment" id="attachment" aria-describedby="attachment" placeholder="">
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label for="remarks" class="form-label-custom required">Remarks</label>
                                <textarea name="remarks" class="form-control border-custom" id="remarks" cols="30" rows="5"></textarea>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label for="leave_reason" class="form-label-custom required">Reason</label>
                                <textarea name="leave_reason" class="form-control border-custom" id="leave_reason" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </form>`);
                    self.setTitle('Input Request Leave');
                }).fail(function () {
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                cancel: function () {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {

                        let leave_type = this.$content.find('#leave_type').val();
                        if (!leave_type) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih leave type',
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                            return false;
                        }

                        let start_date = this.$content.find('#start_date').val();
                        if (!start_date) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih start date',
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                            return false;
                        }

                        let end_date = this.$content.find('#end_date').val();
                        if (!end_date) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih start date',
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                            return false;
                        }

                        let leave_reason = this.$content.find('#leave_reason').val();
                        if (!leave_reason) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih leave reason',
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                            return false;
                        }

                        let kota_val = $("#kota").val();
                        let tgl_ph = $("#tgl_ph").val();
                        let remarks = $("#remarks").val();
                        let attachment = $("#attachment").prop("files")[0];

                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function () { }
                                },
                            },
                            onOpen: function () {
                                let form_data = new FormData();
                                form_data.append("attachment", attachment);
                                form_data.append("tgl_ph",
                                    tgl_ph); // Adding extra parameters to form_data
                                form_data.append("start_date",
                                    start_date); // Adding extra parameters to form_data
                                form_data.append("end_date",
                                    end_date); // Adding extra parameters to form_data
                                form_data.append("leave_type",
                                    leave_type); // Adding extra parameters to form_data
                                form_data.append("reason",
                                    leave_reason); // Adding extra parameters to form_data
                                form_data.append("remarks",
                                    remarks); // Adding extra parameters to form_data
                                form_data.append("kota",
                                    kota_val); // Adding extra parameters to form_data
                                $.ajax({
                                    url: "<?= base_url() ?>dashboard/add_leave", // Upload Script
                                    dataType: 'json',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data, // Setting the data attribute of ajax with file_data
                                    type: 'post',
                                    beforeSend: function () { },
                                    success: function (data) { },
                                }).done(function (response) {
                                    console.log(response);
                                    if (response.status == true) {
                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Berhasil mengajukan request leave!',
                                                buttons: {
                                                    close: {
                                                        actions: function () { }
                                                    },
                                                },
                                            });
                                        }, 250);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal mengajukan request leave! <br>' +
                                                response.error,
                                            buttons: {
                                                close: {
                                                    actions: function () { }
                                                },
                                            },
                                        });
                                    }
                                }).fail(function (jqXHR, textStatus) {
                                    console.log(jqXHR)
                                    console.log(textStatus)
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal mengajukan request leave!' +
                                                textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function () { }
                                                },
                                            },
                                        });
                                    }, 250);
                                });
                                //         $.ajax({
                                //             url: '<?= base_url() ?>dashboard/update_contact_no',
                                //             type: 'POST',
                                //             dataType: 'json',
                                //             data: {
                                //                 contact_no: contact_no
                                //             },
                                //             beforeSend: function() {

                                //             },
                                //             success: function(response) {},
                                //             error: function(xhr) {},
                                //             complete: function() {},
                                //         }).done(function(response) {
                                //             console.log(response);
                                //             if (response.status == true) {
                                //                 get_personal_detail();
                                //                 setTimeout(() => {
                                //                     jconfirm.instances[0].close();
                                //                     $.confirm({
                                //                         icon: 'fa fa-check',
                                //                         title: 'Done!',
                                //                         theme: 'material',
                                //                         type: 'blue',
                                //                         content: 'Berhasil menyimpan nomor baru!',
                                //                         buttons: {
                                //                             close: {
                                //                                 actions: function() {}
                                //                             },
                                //                         },
                                //                     });
                                //                 }, 250);
                                //             } else {
                                //                 jconfirm.instances[0].close();
                                //                 $.confirm({
                                //                     icon: 'fa fa-close',
                                //                     title: 'Oops!',
                                //                     theme: 'material',
                                //                     type: 'red',
                                //                     content: 'Gagal menyimpan nomor baru!',
                                //                     buttons: {
                                //                         close: {
                                //                             actions: function() {}
                                //                         },
                                //                     },
                                //                 });
                                //             }
                                //         }).fail(function(jqXHR, textStatus) {
                                //             setTimeout(() => {
                                //                 jconfirm.instances[0].close();
                                //                 $.confirm({
                                //                     icon: 'fa fa-close',
                                //                     title: 'Oops!',
                                //                     theme: 'material',
                                //                     type: 'red',
                                //                     content: 'Gagal menyimpan nomor baru!' + textStatus,
                                //                     buttons: {
                                //                         close: {
                                //                             actions: function() {}
                                //                         },
                                //                     },
                                //                 });
                                //             }, 250);
                                //         });
                            },

                        });
                    }
                },
            },
            onContentReady: function () {
                $('#div_tgl_ph').hide();
                $('#div_kota').hide();
                $(".tgl").mask('0000-00-00');
                // Running Datepicker
                $('.tanggal').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });
                let kota = NiceSelect.bind(document.getElementById('kota'), options);
                let leave_type = NiceSelect.bind(document.getElementById('leave_type'), options);
                $('#leave_type').on('change', function () {
                    let warning = $(this).find(':selected').data('warning');
                    if (warning != "") {
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Alert!',
                            theme: 'material',
                            columnClass: 'col-12 col-md-8 col-lg-8',
                            type: 'red',
                            content: `<div class="col-md-12">
                                        <div class="alert alert-danger" role="alert">
                                            <h4 class="alert-heading">WARNING !!! Di baca terlebih dahulu sebelum mengisi.</h4>
                                            <p id="content_warning">${warning}</p>
                                            <hr>
                                            <p class="mb-0">Dokumen pendukung wajib dilampirkan dan diberikan kepada personalia maksimal tanggal 21.</p>
                                        </div>
                                    </div>`,
                            buttons: {
                                text: 'Ok, I understand!',
                                close: function () { }
                            }
                        });
                    }
                    leave_type = $(this).val();
                    if (leave_type == 7) {
                        $('#div_tgl_ph').fadeIn();
                        $('#div_tgl_ph_end_date').hide();
                        $('#label_start_date').html('Tgl Pengganti Libur');
                        $('#start_date').on('change', function () {
                            let start = $('#start_date').val()
                            $('#end_date').val(start);
                        });
                    } else {
                        $('#div_tgl_ph').hide();
                        $('#div_tgl_ph_end_date').fadeIn();
                        $('#label_start_date').html('Start Date');
                    }

                    if (leave_type == 13) {
                        $('#div_kota').fadeIn();
                    } else {
                        $('#div_kota').hide();
                    }
                });

                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }


    e_training();

    function e_training() {
        $.ajax({
            url: '<?= base_url() ?>dashboard/e_training',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                console.log(response);
                item_e_training = ``;
                if (response.length > 1) {
                    for (let index = 0; index < response.length; index++) {
                        item_e_training += ` 
                                                <div class="col-12 col-lg-12 col-xl-4 col-xxl-4">
                                                    <div class="card border-0 mb-4">
                                                        <div class="card-header">
                                                            <div class="row align-items-center">
                                                                <div class="col">
                                                                    <h6 class="fw-medium mb-0"></h6>
                                                                    <p class="text-secondary small">Created At : ${response[index].created_at}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="coverimg w-100 h-180 position-relative" style="background-image: url('https://trusmicorp.com/e-training/upload/materi/${response[index].image}');">
                                                            <div class="position-absolute bottom-0 start-0 w-100 mb-3 px-3 z-index-1">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <div class="dropup d-inline-block">
                                                                            <a class="btn btn-square btn-sm rounded-circle btn-outline-light dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                                                                <i class="bi bi-three-dots-vertical"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="feedback()"><i class="bi bi-hand-thumbs-up me-1 text-green"></i> Recommendation this</a></li>
                                                                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="feedback()"><i class="bi bi-hand-thumbs-down me-1 text-danger"></i> Don't recommend</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <img src="https://trusmicorp.com/e-training/upload/materi/${response[index].image}" class="mw-100" alt="" style="display: none;">
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="mb-3">${response[index].training}</h5>
                                                            <p class="text-secondary">Anda bisa pelajari materi ini dari Aplikasi E-Training</p>
                                                            <a class="button-4 float-end" href="https://trusmicorp.com/e-training/question/exam/${response[index].id_training}/1" target="_blank">Go to E-Training <i class="bi bi-arrow-up-right-square vm me-2"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            `
                    }
                    $('#content_e_training').empty().append(item_e_training);
                } else {
                    item_e_training = `<div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
                                               No Data
                                        </div>`
                    $('#content_e_training').empty().append(item_e_training);
                }
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        });
    }

    function feedback() {
        $.confirm({
            icon: 'fa fa-check',
            title: 'Thank You!',
            theme: 'material',
            type: 'green',
            content: 'Terima kasih sudah memberikan Feedback',
            buttons: {
                close: function () { }
            }
        });
    }

    // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    // var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    //     return new bootstrap.Tooltip(tooltipTriggerEl)
    // })

    function show_dont_dos() {
        got_it = "<?= $personal_info->got_it; ?>";
        got_it_banner = "<?= $personal_info->got_it_banner; ?>";

        base_url = '<?= base_url() ?>assets/img/info_banner/';

        const imageUrls = [
            `${base_url}1.jpeg`,
            `${base_url}2.jpeg`,
            `${base_url}3.jpeg`,
            `${base_url}4.jpeg`,
            `${base_url}5.jpeg`,
            `${base_url}6.jpeg`,
        ];


        const randomBannerNumber = getRandomBannerNumber(imageUrls, got_it_banner);

        document.getElementById('info_banner').src = imageUrls[randomBannerNumber]

        if (got_it == '0') {
            $('#modal_dont_dos').modal('show');
            $('#got_it_banner').val(randomBannerNumber);
        } else {
            reminder_change_password = "<?= $personal_info->reminder_change_password; ?>";
            if (reminder_change_password == '1') {
                $('#modal_reminder_change_password').modal('show');
                $('#btn_close_change_password').addClass('d-none');
            } else {
                $('#btn_close_change_password').removeClass('d-none');
            }
        }
    }

    function getRandomBannerNumber(array, lastIndex) {
        // return Math.floor(Math.random() * array.length);
        let randomIndex;
        do {
            randomIndex = Math.floor(Math.random() * array.length);
        } while (randomIndex == lastIndex);

        return randomIndex;
    }

    // $(document).ready(function() {
    //     let is_modal_dont_dos = $('#modal_dont_dos').is(':visible');
    //     let is_reminder_change_password = "<?= $personal_info->reminder_change_password; ?>";
    //     console.log(is_modal_dont_dos);
    //     console.log(is_reminder_change_password);
    //     if (is_reminder_change_password == '1' && is_modal_dont_dos == false) {
    //         show_reminder_change_password();
    //     }
    // });

    function show_reminder_change_password() {
        reminder_change_password = "<?= $personal_info->reminder_change_password; ?>";
        if (reminder_change_password == '1') {
            $('#modal_reminder_change_password').modal('show');
            $('#btn_close_change_password').addClass('d-none');
        } else {
            $('#btn_close_change_password').removeClass('d-none');
        }
    }

    function update_got_it() {
        user_id = "<?= $personal_info->user_id; ?>";
        banner_index = $('#got_it_banner').val();
        $.ajax({
            url: "<?= base_url('dashboard/update_got_it') ?>",
            type: "POST",
            dataType: "json",
            data: {
                user_id: user_id,
                banner_index: banner_index,
            },
            success: function (response) {
                // console.info(`response ${response}`);
                show_reminder_change_password()
            },
            error: function (err) {
                console.info(`error ${err}`);

            },
            complete: function () {
                $('#modal_dont_dos').modal('hide');
            }
        })
    }

    // $('#showNotification').on('click', function() {
    //     if (body.hasClass('rightbar-open') != true && notificationwindow.hasClass('d-none') === true) {
    //         body.addClass('rightbar-open');
    //         notificationwindow.removeClass('d-none');
    //         chatwindow.addClass('d-none');
    //     } else if (body.hasClass('rightbar-open') === true && notificationwindow.hasClass('d-none') === true) {
    //         notificationwindow.removeClass('d-none');
    //         chatwindow.addClass('d-none');
    //     } else {
    //         body.removeClass('rightbar-open');
    //         setTimeout(function() {
    //             notificationwindow.addClass('d-none');
    //         }, 500);
    //     }
    // });

    function show_ultah() {
        $('#modal_ultah').modal('show');

        const colors = ['#e63946', '#f1faee', '#a8dadc', '#457b9d', '#ffbe0b'];

        // Falling confetti
        for (let i = 0; i < 100; i++) {
            const confetti = document.createElement('div');
            confetti.classList.add('confetti');
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.top = Math.random() * -100 + 'px';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDuration = 2 + Math.random() * 3 + 's';
            confetti.style.width = confetti.style.height = Math.random() * 8 + 4 + 'px';
            document.body.appendChild(confetti);
        }
    }

    // --- SETUP DASAR ---
    const ttdModal = document.getElementById('modal_ttd');
    const canvas = document.getElementById('signature-pad');
    const container = document.getElementById('signature-pad-container');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255, 255, 255, 0)' // Latar belakang transparan
    });
    $(function () {




        // --- FUNGSI UTAMA UNTUK RESIZE CANVAS ---
        function resizeCanvas() {
            console.log("Resizing canvas..."); // Untuk debugging, bisa dihapus
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = container.offsetWidth * ratio;
            canvas.height = container.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            signaturePad.clear(); // Bersihkan canvas setiap kali ukurannya diubah
            console.log("Canvas resized to:", canvas.width, "x", canvas.height); // Debugging
        }

        // --- LOGIKA UTAMA: EVENT LISTENER ---

        // 1. Panggil resizeCanvas SETIAP KALI MODAL SELESAI DITAMPILKAN
        ttdModal.addEventListener('shown.bs.modal', function () {
            resizeCanvas();
        });

        // 2. (Opsional tapi bagus) Panggil juga saat window di-resize JIKA modal sedang terbuka
        window.addEventListener("resize", function () {
            if ($('#modal_ttd').is(':visible')) {
                resizeCanvas();
            }
        });

        // 3. Event untuk tombol-tombol
        $('#clear-button').on('click', function () {
            signaturePad.clear();
        });
    });
    function update_ttd_digital() {
        if (signaturePad.isEmpty()) {
            alert("Silakan bubuhkan tanda tangan terlebih dahulu.");
            return;
        }

        const dataURL = signaturePad.toDataURL('image/png');
        $.ajax({
            url: '<?= base_url("dashboard/update_ttd_digital"); ?>',
            type: 'POST',
            data: {
                signature: dataURL
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    
                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Done!',
                        theme: 'material',
                        type: 'blue',
                        content: 'Berhasil, update data ttd digital',
                        buttons: {
                            close: {
                                actions: function () { }
                            },
                        },
                    });
                    $('#modal_ttd').modal('hide');
                    // alert('Tanda tangan berhasil disimpan! File: ' + response.file);
                    signaturePad.clear();
                } else {
                    $.confirm({
                        icon: 'fa fa-close',
                        title: 'Done!',
                        theme: 'material',
                        type: 'red',
                        content: 'Gagal, update data ttd digital',
                        buttons: {
                            close: {
                                actions: function () { }
                            },
                        },
                    });
                }
            },
            error: function () {
                alert('Terjadi kesalahan saat menghubungi server.');
            }
        });
    }
</script>