<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<script>
    async function speechToText({
        outPut,
        clearBtn,
        startBtn,
        stopBtn,
        copyBtn,
        langSelection,
    }) {
        let speachRec = window.webkitSpeechRecognition || window.SpeechRecognition;
        if (!speachRec) {
            alert("Speech Recognition API is not supported in this browser.");
            console.error("Speech Recognition API is unsupported.");
            return;
        }
        const outputHolder = document.querySelector(outPut),
            startBtnEl = document.querySelector(startBtn),
            stopBtnEl = stopBtn ? document.querySelector(stopBtn) : null,
            clearBtnEl = clearBtn ? document.querySelector(clearBtn) : null,
            copyBtnEl = copyBtn ? document.querySelector(copyBtn) : null,
            langSelect = document.querySelector(langSelection);
        if (!startBtnEl || !outputHolder || !langSelection) {
            if (!startBtnEl) {
                console.error("incomplete html format missing start button");
            } else if (!outputHolder) {
                console.error("incomplete html format missing output holder");
            } else {
                console.error("incomplete html format missing language select");
            }
            alert("Something missing please check document");
            window.open(
                "https://github.com/DarpanAdhikari/speech-into-text?tab=readme-ov-file#getting-started",
                "_blank"
            );
            return;
        }
        let sr = window.webkitSpeechRecognition || window.SpeechRecognition;

        if (!sr) {
            alert("Speech Recognition API is not supported in this browser.");
            return;
        }
        let spRec = new sr();
        spRec.continuous = true;
        spRec.interimResults = true;

        const languagePlaceholders = {
            "ne-NP": "बोल्न सुरु गर्नु होस्...",
            "hi-IN": "बोलना शुरू करें...",
            "zh-CN": "开始说话...",
            "fr-FR": "Commencez à parler...",
            "de-DE": "Fangen Sie an zu sprechen...",
            "ja-JP": "話し始めてください...",
            "ko-KR": "말을 시작하세요...",
            "pt-PT": "Comece a falar...",
            "es-ES": "Comienza a hablar...",
            "ru-RU": "Начните говорить...",
            "en-US": "Start speaking...",
            "ar-SA": "ابدأ التحدث...",
            "it-IT": "Inizia a parlare...",
            "tr-TR": "Konuşmaya başlayın...",
            "pl-PL": "Zacznij mówić...",
            "nl-NL": "Begin met praten...",
            "sv-SE": "Börja prata...",
            "da-DK": "Begynd at tale...",
            "cs-CZ": "Začněte mluvit...",
            "fi-FI": "Aloita puhuminen...",
            "el-GR": "Άρχισε να μιλάς...",
            "th-TH": "เริ่มพูด...",
            "hu-HU": "Kezdj el beszélni...",
            "ro-RO": "Începeți să vorbiți...",
            "sk-SK": "Začnite hovoriť...",
            "hr-HR": "Počnite govoriti...",
            "bg-BG": "Започнете да говорите...",
            "sr-RS": "Počnite da govorite...",
            "vi-VN": "Bắt đầu nói...",
            "ms-MY": "Mulakan bercakap...",
            "id-ID": "Mulai berbicara...",
            "ta-IN": "பேசத் தொடங்குங்கள்...",
            "ml-IN": "പറയാൻ ആരംഭിക്കൂ...",
        };

        const languages = [{
                code: "en-US",
                name: "English (United States)"
            },
            {
                code: "ar-SA",
                name: "Arabic (Saudi Arabia)"
            },
            {
                code: "bg-BG",
                name: "Bulgarian (Bulgaria)"
            },
            {
                code: "zh-CN",
                name: "Chinese (China)"
            },
            {
                code: "hr-HR",
                name: "Croatian (Croatia)"
            },
            {
                code: "cs-CZ",
                name: "Czech (Czech Republic)"
            },
            {
                code: "da-DK",
                name: "Danish (Denmark)"
            },
            {
                code: "nl-NL",
                name: "Dutch (Netherlands)"
            },
            {
                code: "en-GB",
                name: "English (United Kingdom)"
            },
            {
                code: "fi-FI",
                name: "Finnish (Finland)"
            },
            {
                code: "fr-FR",
                name: "French (France)"
            },
            {
                code: "de-DE",
                name: "German (Germany)"
            },
            {
                code: "el-GR",
                name: "Greek (Greece)"
            },
            {
                code: "hi-IN",
                name: "Hindi (India)"
            },
            {
                code: "ta-IN",
                name: "Tamil (India)"
            },
            {
                code: "ml-IN",
                name: "Malayalam (India)"
            },
            {
                code: "hu-HU",
                name: "Hungarian (Hungary)"
            },
            {
                code: "id-ID",
                name: "Indonesian (Indonesia)"
            },
            {
                code: "it-IT",
                name: "Italian (Italy)"
            },
            {
                code: "ja-JP",
                name: "Japanese (Japan)"
            },
            {
                code: "ko-KR",
                name: "Korean (Korea)"
            },
            {
                code: "ms-MY",
                name: "Malay (Malaysia)"
            },
            {
                code: "ne-NP",
                name: "Nepali (Nepal)"
            },
            {
                code: "pl-PL",
                name: "Polish (Poland)"
            },
            {
                code: "pt-PT",
                name: "Portuguese (Portugal)"
            },
            {
                code: "ro-RO",
                name: "Romanian (Romania)"
            },
            {
                code: "ru-RU",
                name: "Russian (Russia)"
            },
            {
                code: "sr-RS",
                name: "Serbian (Serbia)"
            },
            {
                code: "sk-SK",
                name: "Slovak (Slovakia)"
            },
            {
                code: "es-ES",
                name: "Spanish (Spain)"
            },
            {
                code: "sv-SE",
                name: "Swedish (Sweden)"
            },
            {
                code: "th-TH",
                name: "Thai (Thailand)"
            },
            {
                code: "tr-TR",
                name: "Turkish (Turkey)"
            },
            {
                code: "vi-VN",
                name: "Vietnamese (Vietnam)"
            },
        ];
        let selectedLanguage = null;
        const LangExists = languages.some(
            (language) => language.code === langSelection
        );
        if (langSelect) {
            langSelect.innerHTML = "";
            languages.forEach((lang) => {
                const option = document.createElement("option");
                option.value = lang.code;
                option.textContent = lang.name;
                langSelect.appendChild(option);
            });
            const langStored = sessionStorage.getItem("language");
            const langOptions = langSelect.querySelectorAll("option");
            if (langSelect && langSelect !== "" && langOptions.length > 0) {
                langSelect.querySelectorAll("option").forEach((opt) => {
                    if (opt.value == langStored) {
                        opt.selected = true;
                    }
                });
            }
            selectedLanguage = langSelect.value;
            langSelect.addEventListener("change", () => {
                spRec.stop();
                selectedLanguage = langSelect.value;
                spRec.lang = langSelect.value;
                outputHolder.setAttribute(
                    "placeholder",
                    languagePlaceholders[selectedLanguage] || "Start speaking..."
                );
            });
        } else if (LangExists) {
            selectedLanguage = langSelection;
        } else {
            alert("Unsupportive language");
            window.open(
                "https://github.com/DarpanAdhikari/speech-into-text?tab=readme-ov-file#supported-languages",
                "_blank"
            );
            return;
        }
        spRec.lang = selectedLanguage;

        outputHolder.setAttribute(
            "placeholder",
            languagePlaceholders[selectedLanguage] || "Start speaking..."
        );

        let isSpeaking = false;
        let firstAction = true;
        let previousData = "";
        startBtnEl.addEventListener("click", () => {
            if (!isSpeaking) {
                spRec.start();
                isSpeaking = true;
                let outVal = "";
                if (
                    outputHolder.tagName === "INPUT" ||
                    outputHolder.tagName === "TEXTAREA"
                ) {
                    outVal = outputHolder.value.trim();
                } else {
                    outVal = outputHolder.innerHTML.trim();
                }
                if (firstAction && outVal !== "") {
                    previousData = outVal;
                    firstAction = false;
                }
                outputHolder.setAttribute(
                    "placeholder",
                    languagePlaceholders[selectedLanguage] || "Start speaking..."
                );
            } else {
                spRec.stop();
                listeningIsStoped();
            }
        });

        let text = "";
        spRec.onresult = (res) => {
            text += Array.from(res.results)
                .filter((r) => r.isFinal)
                .map((r) => r[0])
                .map((txt) => txt.transcript)
                .join("");
            if (text) {
                setTextToField(text);
                text = "";
            }
        };

        function setTextToField(data) {
            if (
                outputHolder.tagName === "INPUT" ||
                outputHolder.tagName === "TEXTAREA"
            ) {
                if (!previousData.endsWith(data.trim())) {
                    outputHolder.value = previousData + " " + data;
                }
            } else {
                if (!previousData.endsWith(data.trim())) {
                    outputHolder.innerHTML = previousData + " " + data;
                }
            }
        }
        spRec.onend = () => {
            if (isSpeaking && !isMobileDevice()) {
                spRec.start();
            }
        };

        function isMobileDevice() {
            return /Mobi|Android/i.test(navigator.userAgent);
        }

        function listeningIsStoped() {
            isSpeaking = false;
            document.querySelector(".indicator")?.classList.remove("listening");
            if (!previousData.endsWith(text.trim())) {
                previousData = "";
                setPreviousData();
            }
        }

        function setPreviousData() {
            if (
                outputHolder.tagName === "INPUT" ||
                outputHolder.tagName === "TEXTAREA"
            ) {
                previousData = outputHolder.value.trim();
            } else {
                previousData = outputHolder.innerHTML.trim();
            }
        }
        spRec.onstart = () => {
            document.querySelector(".indicator")?.classList.add("listening");
        };
        outputHolder.addEventListener("blur", (e) => {
            setPreviousData()
        });
        spRec.onerror = (event) => {
            setPreviousData();
            console.error("Speech recognition error", event.error);
            const warningDiv = document.createElement("div");
            warningDiv.id = "warningDiv";
            warningDiv.textContent =
                "We found some error while listening to the voice. Voice typing is still working." + event;
            warningDiv.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      margin: 0 auto;
      width: max-content;
      background-color: #ffcc00;
      color: #000;
      text-align: center;
      padding: 10px;
      font-size: 16px;
      z-index: 1000;
      border: 1px solid #000;
      border-radius: 5px;
    `;
            document.body.appendChild(warningDiv);
            setTimeout(() => {
                warningDiv.remove();
            }, 5000);
            if (event.error === "not-allowed") {
                alert("Microphone access denied. Please allow microphone permissions.");
            }
        };

        stopBtnEl?.addEventListener("click", () => {
            if (isSpeaking) {
                spRec.stop();
                listeningIsStoped();
            }
        });

        clearBtnEl?.addEventListener("click", () => {
            if (
                outputHolder.tagName === "INPUT" ||
                outputHolder.tagName === "TEXTAREA"
            ) {
                outputHolder.value = "";
            } else {
                outputHolder.innerHTML = "";
            }
            previousData = "";
        });

        copyBtnEl?.addEventListener("click", () => {
            let buttonText = copyBtnEl.innerHTML.trim();
            let outVal = "";
            if (
                outputHolder.tagName === "INPUT" ||
                outputHolder.tagName === "TEXTAREA"
            ) {
                outVal = outputHolder.value.trim();
            } else {
                outVal = outputHolder.innerHTML.trim();
            }
            if (outVal !== "") {
                navigator.clipboard.writeText(outVal);
                copyBtnEl.textContent = "Copied!";
                setTimeout(() => {
                    copyBtnEl.textContent = buttonText;
                }, 2000);
            }
        });
        window.addEventListener("beforeunload", (event) => {
            sessionStorage.setItem("language", langSelect.value);
        });
    }
</script>
<script>
    function is_eaf() {
        if ($('#kategori').val() === 'Eaf') {
            $('#field_nominal').removeClass('d-none');
        } else {
            $('#field_nominal').addClass('d-none');
        }
    }

    function reject() {
        $('#btn_reject').prop('disabled', true);
        $('#btn_approve').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/reject',
            type: 'POST',
            dataType: 'JSON',
            data: $('#formApprove').serialize(),
            success: function(response) {
                $('#formApprove')[0].reset();
                $('#btn_approve').prop('disabled', false);
                $('#btn_reject').prop('disabled', false);
                $('#modalApprove').modal('hide');
                approve_to = response.approve_to;
                requested_by = response.created_by;
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                user_id_approve_to = response.user_id_approve_to;
                no_app = response.no_app;
                subject = response.subject;
                description = response.description;
                note = response.approve_note;
                nomorHp = response.created_by_contact;
                created_by_contact = [
                    nomorHp
                ];
                msg = `📣 Alert!!!
Your Request Has Been Reject ❌
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Rejected ❌
Note : ${note}

🌐 Anda Bisa Melakukan Pengajuan Ulang melalui link:    
https://trusmiverse.com/apps/login/verify?u=${requested_by}&id=${no_app}
`;
                send_wa(created_by_contact, msg);


                window.location.href = "<?= base_url(); ?>/trusmi_approval";

                new PNotify({
                    title: `Success`,
                    text: `Request Rejected`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500,
                });
            }
        });
    }

    function approve() {
        $('#btn_reject').prop('disabled', true);
        $('#btn_approve').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/approve',
            type: 'POST',
            dataType: 'JSON',
            data: $('#formApprove').serialize(),
            success: function(response) {
                $('#formApprove')[0].reset();
                $('#btn_approve').prop('disabled', false);
                $('#btn_reject').prop('disabled', false);
                $('#modalApprove').modal('hide');
                approve_to = response.approve_to;
                requested_by = response.created_by;
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                user_id_approve_to = response.user_id_approve_to;
                no_app = response.no_app;
                subject = response.subject;
                description = response.description;
                note = response.approve_note;
                nomorHp = response.created_by_contact;
                kategori = response.kategori;
                nominal = response.nominal;
                created_by_contact = [
                    nomorHp
                ];
                if (kategori != 'Eaf') {
                    msg = `📣 Alert!!!
Your Request Has Been Processed
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Approved ✅
Note : ${note}`;
                } else {
                    msg = `📣 Alert!!!
Your Request Has Been Processed
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Approved ✅
Note : ${note}
🌐 Link EAF : 
                    
https://trusmiverse.com/apps/login/eaf?u=${requested_by}&id=${no_app}`;
                }
                send_wa(created_by_contact, msg);



                window.location.href = "<?= base_url(); ?>/trusmi_approval";

                new PNotify({
                    title: `Success`,
                    text: `Request Approved`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500
                });
            }
        });
    }
    $('#form_resubmit').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $('#btn_resubmit').attr('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>trusmi_approval/resubmit",
            data: form.serialize(),
            dataType: "json",
            success: function(response) {
                new PNotify({
                    title: `Success`,
                    text: `Request Sent!`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500
                });
                no_app = response.no_app;
                contact = response.approve_to_contact;
                user_id_approve_to = response.user_id_approve_to;
                approve_to = response.approve_to;
                requested_by = "<?= $this->session->userdata('nama'); ?>";
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                leadtime = response.leadtime;
                subject = response.subject;
                description = response.description;
                array_contact = [
                    contact
                ];

                if (user_id_approve_to == 803) { // jika approval ke pa i maka cc juga ke mba lintang
                    array_contact.push('628882680008');
                    array_contact.push('62895422833253');

                }
                msg = `📣 Alert!!!
*There is New Request Approval Resubmit*
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}
🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify?u=${user_id_approve_to}&id=${no_app}`;
                send_wa(array_contact, msg);
                window.location.href = "<?= base_url(); ?>/trusmi_approval";
            }
        });
    });

    function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

                extension = 'png,';

                imgElement.onload = function(e) {
                    const canvas = document.createElement("canvas");

                    if (e.target.width > e.target.height) {
                        const MAX_WIDTH = 1024;
                        const scaleSize = MAX_WIDTH / e.target.width;
                        canvas.width = MAX_WIDTH;
                        canvas.height = e.target.height * scaleSize;
                    } else {
                        const MAX_HEIGHT = 1024;
                        const scaleSize = MAX_HEIGHT / e.target.height;
                        canvas.height = MAX_HEIGHT;
                        canvas.width = e.target.width * scaleSize;
                    }

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                    var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
                    // document.querySelector(string).value = g_string;
                    saveFile(g_string, wait, done, string, submit);
                }
            } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                // document.querySelector(string).value = g_string;
                saveFile(g_string, wait, done, string, submit);
            }


        }

        function saveFile(string, wait, done, str, submit) {

            $.ajax({
                'url': '<?php echo base_url() ?>trusmi_approval/upload_file',
                'type': 'POST',
                'data': {
                    string: string
                },
                'success': function(response) {
                    document.querySelector(str).value = response;
                    $(submit).prop('disabled', false);
                    $(wait).hide();
                    $(done).show();
                }
            });
        }
    }
</script>

<script>
    // const recordBtn = document.querySelector('.record-btn');
    // const voiceIndicator = document.querySelector('.voice-indicator');
    // const waveBars = document.querySelectorAll('.wave-bar');
    // let isRecording = false;
    // let mediaRecorder;
    // let audioChunks = [];

    // // Audio processing
    // async function startRecording() {
    //     try {
    //         const stream = await navigator.mediaDevices.getUserMedia({
    //             audio: true
    //         });
    //         const audioContext = new AudioContext();
    //         const analyser = audioContext.createAnalyser();
    //         const microphone = audioContext.createMediaStreamSource(stream);

    //         microphone.connect(analyser);
    //         analyser.fftSize = 256;

    //         mediaRecorder = new MediaRecorder(stream);

    //         mediaRecorder.ondataavailable = (e) => {
    //             audioChunks.push(e.data);
    //         };

    //         mediaRecorder.onstop = async () => {
    //             const audioBlob = new Blob(audioChunks, {
    //                 type: 'audio/wav'
    //             });
    //             // Process audio blob here
    //         };

    //         // Audio analysis
    //         const bufferLength = analyser.frequencyBinCount;
    //         const dataArray = new Uint8Array(bufferLength);

    //         const checkVolume = () => {
    //             analyser.getByteFrequencyData(dataArray);
    //             const volume = Math.max(...dataArray);
    //             const isSoundDetected = volume > 20;
    //             console.log(volume);
    //         };

    //         mediaRecorder.start();
    //         checkVolume();
    //         toggleWaveAnimation(true);
    //         isRecording = true;
    //         recordBtn.classList.add('recording');
    //     } catch (err) {
    //         console.error('Error accessing microphone:', err);
    //     }
    // }

    // function stopRecording() {
    //     mediaRecorder.stop();
    //     isRecording = false;
    //     recordBtn.classList.remove('recording');
    //     toggleWaveAnimation(false);
    // }

    function toggleWaveAnimation(active) {
        if (active) {
            document.querySelectorAll('.sound-wave .bar-idle').forEach(el => {
                el.classList.remove('bar-idle');
                el.classList.add('bar');
            });
        } else {
            document.querySelectorAll('.sound-wave .bar').forEach(el => {
                el.classList.remove('bar');
                el.classList.add('bar-idle');
            });
        }
    }

    // $('#startRecord').on('click', function() {
    //     startRecording();
    //     $('#txt_speech').html('Mendengarkan Suara...');
    //     $('#startRecord').addClass('d-none');
    //     $('#stopRecord').removeClass('d-none');
    // });

    // $('#stopRecord').on('click', function() {
    //     stopRecording();
    //     $('#txt_speech').html('Fitur Speech to Text');
    //     $('#startRecord').removeClass('d-none');
    //     $('#stopRecord').addClass('d-none');
    // });


    // import { speechToText } from 'https://unpkg.com/speech-into-text@latest/index.js';

    // speechToText({
    //     outPut: '#approve_note',
    //     startBtn: '#startRecord',
    //     langSelection: 'id-ID', // or for specific langanguage use code like langSelection:"ne-NP"
    //     // other are optional include any of those if required
    //     stopBtn: '#stopRecord',
    //     clearBtn: "#clearBtn",
    //     copyBtn: "",
    //     recIndicator: "#indicator", //optional add css to view change on its class "listening"
    // });
</script>

<script>
    const NUM_BARS = 10;
    const barsContainer = document.getElementById('bars');

    // Bikin bar
    for (let i = 0; i < NUM_BARS; i++) {
        const bar = document.createElement('div');
        bar.className = 'bar';
        barsContainer.appendChild(bar);
    }

    const bars = document.querySelectorAll('.bar');

    async function startMic() {
        const stream = await navigator.mediaDevices.getUserMedia({
            audio: true
        });
        const audioContext = new(window.AudioContext || window.webkitAudioContext)();
        const source = audioContext.createMediaStreamSource(stream);
        const analyser = audioContext.createAnalyser();

        source.connect(analyser);
        analyser.fftSize = 256;

        const bufferLength = analyser.frequencyBinCount;
        const dataArray = new Uint8Array(bufferLength);

        function animate() {
            analyser.getByteFrequencyData(dataArray);

            for (let i = 0; i < NUM_BARS; i++) {
                const value = dataArray[i * 2]; // ambil sebagian frekuensi
                const percent = value / 255;
                const height = Math.max(5, percent * 50); // tinggi minimal 5px
                bars[i].style.height = `${height}px`;

                // Ubah warna juga kalau mau
                bars[i].style.backgroundColor = `hsl(${percent * 120}, 100%, 60%)`;
            }

            requestAnimationFrame(animate);
        }

        animate();
    }
</script>


<script>
    let chunks = [];

    let mediaRecorder;
    const recordBtn = document.getElementById('startRecord');
    const clearBtn = document.getElementById('clearBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const status = document.getElementById('txt_speech');
    const text = document.getElementById('text');

    recordBtn.addEventListener('click', async () => {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
            mediaRecorder = new MediaRecorder(stream);
            chunks = [];
            isCancelled = false;

            mediaRecorder.ondataavailable = (e) => chunks.push(e.data);

            mediaRecorder.onstop = async () => {
                cancelBtn.disabled = true;
                recordBtn.innerHTML = '<i class="bi bi-mic"></i>';

                if (isCancelled) {
                    status.textContent = 'Dibatalkan oleh pengguna.';
                    text.textContent = '';
                    chunks = [];
                    return;
                }

                const blob = new Blob(chunks, {
                    type: 'audio/webm'
                });

                if (blob.size < 1000) {
                    status.textContent = 'Tidak ada suara terdeteksi.';
                    text.textContent = '';
                    return;
                }

                const formData = new FormData();
                formData.append('audio', blob, 'audio.webm');

                status.textContent = 'Uploading...';

                try {
                    const response = await fetch('http://localhost/upload', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.text) {
                        text.textContent = 'Transkrip: ' + result.text;
                    } else {
                        text.textContent = 'Tidak ada teks dikenali.';
                    }
                } catch (err) {
                    text.textContent = 'Terjadi kesalahan saat upload.';
                    console.error(err);
                }

                status.textContent = 'Selesai';
                chunks = [];
            };

            mediaRecorder.start();
            toggleWaveAnimation(true);
            status.textContent = 'Merekam...';
            recordBtn.textContent = 'Selesai';
            cancelBtn.disabled = false;
        } else {
            mediaRecorder.stop();
            toggleWaveAnimation(false);
        }
    });

    cancelBtn.addEventListener('click', () => {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            isCancelled = true;
            mediaRecorder.stop();
            toggleWaveAnimation(false);
        }
    });
</script>