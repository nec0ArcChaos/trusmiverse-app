<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script>
    var base_url = '<?= base_url('ai_burnout/main'); ?>';
    
    // Master Data
    var SYMPTOMS = [];

    var DIAGNOSES = [];

    var SOLUTIONS = {};

    var RULES = {};
    const isMobile = window.innerWidth < 640 || ('ontouchstart' in window);
    
    // =========================
    // CONFIG / DATA DEFINITIONS
    // =========================

    // Daftar gejala dengan cfPakar yang direkomendasikan (0.0 - 1.0)

    // Diagnosa dan solusi (sederhana)


    // Pilihan jawaban (UI). Ini adalah pilihan *opsional* — nilai numeric harus diinterpretasikan sebagai cfUser (-1..1).
    // Anda bisa memakai pilihan ini secara langsung (nilai range -1..1), atau gunakan skala Likert 0..1 bila ingin hanya mendukung dukungan (positif).
    const ANSWER_OPTIONS = [
        { text: 'Pasti Tidak', value: -1.0 },
        { text: 'Hampir Pasti Tidak', value: -0.8 },
        { text: 'Kemungkinan Besar Tidak', value: -0.6 },
        { text: 'Mungkin Tidak', value: -0.4 },
        { text: 'Tidak Tahu', value: 0.0 },
        { text: 'Mungkin', value: 0.4 },
        { text: 'Kemungkinan Besar', value: 0.6 },
        { text: 'Hampir Pasti', value: 0.8 },
        { text: 'Pasti', value: 1.0 }
    ];

    // Alternatif: jika ingin skala non-negatif (0..1) untuk user, gunakan mappingLIKERT
    const ANSWER_LIKERT = [
        { text: 'Tidak Pernah', value: 0.0 },
        { text: 'Jarang', value: 0.2 },
        { text: 'Kadang', value: 0.4 },
        { text: 'Sering', value: 0.6 },
        { text: 'Sering Sekali', value: 0.8 },
        { text: 'Selalu', value: 1.0 }
    ];

    // =========================
    // CLUSTERS (untuk gabungan bertingkat)
    // =========================
    const CLUSTERS = {
        'workload': ['G1','G2','G3','G5','G7','G10','G6'], // Beban kerja, deadline, target
        'control': ['G4','G11','G23','G24','G25','G28','G33','G34','G36'], // Kontrol / Kejelasan peran / otoritas tugas
        'support': ['G18','G19','G20','G21','G22','G42'], // Dukungan sosial & feedback (atasan & rekan kerja)
        'communication': ['G26','G27','G29','G31','G32','G35'], // Komunikasi & prosedur administratif
        'career': ['G37','G38','G39','G40','G41','G43'], // Karir & perkembangan (promosi, skill, peluang)
        'environment': ['G8','G9'], // Lingkungan kerja fisik / fasilitas / gangguan
        'role_conflict': ['G12','G15','G16','G17'], // Konflik peran / tugas yang bertentangan / multi-atasan
        'management': ['G14','G30','G31'], // Gaya manajerial yang mengganggu (micromanagement / regulasi berlebih) 
    };

    // Ambang / konfigurasi
    const CONFIG = {
        symptomThreshold: 0.05,  // minimal abs(CF[H,E]) untuk dipertimbangkan
        clusterThreshold: 0.0,   // jika cluster kosong -> 0
        interpretation: [
            { min: 0.70, max: 1.0, label: 'D4' },  // Stres Tinggi
            { min: 0.50, max: 0.69, label: 'D3' },  // Stres Sedang
            { min: 0.30, max: 0.49, label: 'D2' },  // Stres Rendah
            { min: -1.0,  max: 0.29, label: 'D1' }   // Tidak Stres / Minor (termasuk negatif)
        ]
    };

    // =========================
    // CF FUNCTIONS (MYCIN-correct)
    // =========================

    // Hitung CF[H,E] untuk satu gejala: cfPakar * cfUser
    function calculateCFHE(cfPakar, cfUser){
        // memastikan value dalam range [-1, 1]
        const cp = Math.max(-1, Math.min(1, cfPakar));
        const cu = Math.max(-1, Math.min(1, cfUser));
        // hasil di range [-1,1]
        return +(cp * cu);
    }

    // Kombinasi dua CF menggunakan aturan MYCIN yang benar
    function combineTwoCF(cf1, cf2){
        // memastikan numeric
        cf1 = Number(cf1);
        cf2 = Number(cf2);

        // both positive
        if (cf1 >= 0 && cf2 >= 0) {
            return +(cf1 + cf2 * (1 - cf1));
        }

        // both negative
        if (cf1 <= 0 && cf2 <= 0) {
            return +(cf1 + cf2 * (1 + cf1));
        }

        // different signs (mixed)
        const denom = 1 - Math.min(Math.abs(cf1), Math.abs(cf2));
        if (denom === 0) {
            // sangat jarang; fallback defensif
            return 0;
        }
        return +((cf1 + cf2) / denom);
    }

    // Menggabungkan list CF secara iteratif.
    // Urutan kombinasinya: descending by absolute value (stabilitas numerik)
    function iterativeCombineCF(cfList){
        if (!Array.isArray(cfList) || cfList.length === 0) return 0.0;
        // sort berdasarkan magnitude descending
        const sorted = [...cfList].sort((a,b) => Math.abs(b) - Math.abs(a));
        let current = sorted[0];
        for (let i = 1; i < sorted.length; i++){
            current = combineTwoCF(current, sorted[i]);
        }
        return current;
    }

    // =========================
    // CALC HELPERS
    // =========================

    // Dapatkan objek gejala berdasarkan id
    function getSymptomById(id){
        return SYMPTOMS.find(s => s.id === id) || null;
    }

    // Hitung CF cluster (gabungan gejala dalam satu cluster)
    function calculateClusterCF(clusterName, userAnswers, options = { threshold: CONFIG.symptomThreshold }){
        const members = CLUSTERS[clusterName] || [];
        // kumpulkan CF[H,E] untuk anggota cluster yang di-respond oleh user
        const cfHEs = [];
        for (const gid of members){
            const sym = getSymptomById(gid);
            if (!sym) continue;
            // userAnswers harus berisi nilai cfUser numeric untuk gid (mis. -1..1 atau 0..1)
            if (userAnswers.hasOwnProperty(gid)){
            const cfUser = Number(userAnswers[gid]);
            const cfhe = calculateCFHE(sym.cfPakar, cfUser);
            if (Math.abs(cfhe) >= options.threshold) {
                cfHEs.push(+cfhe);
            }
            }
        }
        if (cfHEs.length === 0) return 0.0;
        return iterativeCombineCF(cfHEs);
    }

    // Gabungkan semua cluster menjadi CF_overall
    function calculateOverallCF(userAnswers){
        // hitung CF tiap cluster
        const clusterCFs = [];
        for (const clusterName of Object.keys(CLUSTERS)){
            const cfCluster = calculateClusterCF(clusterName, userAnswers);
            // hanya masukkan cluster yang punya kontribusi signifikan (>= 0.01 mis.)
            if (Math.abs(cfCluster) >= 0.01) clusterCFs.push(cfCluster);
        }
        if (clusterCFs.length === 0) return 0.0;
        return iterativeCombineCF(clusterCFs);
    }

    // Interpretasi hasil akhir jadi diagnosis id (D1..D4)
    function interpretCF(cfOverall){
        for (const rule of CONFIG.interpretation){
            if (cfOverall >= rule.min) {
                return rule.label;
            }
        }
        return 'D1';
    }

    // =========================
    // DIAGNOSE FUNCTION (public)
    // =========================

    // userAnswers: object mapping { 'G1': numeric, 'G2': numeric, ... }
    // dimana numeric adalah cfUser (contoh: -1..1 dari ANSWER_OPTIONS or 0..1 from Likert)
    function diagnose(){
        // Validate: userAnswers should be object
        if (typeof userAnswers !== 'object' || userAnswers === null) {
            throw new Error('userAnswers harus berupa object mapping symptomId => numeric cfUser');
        }

        // compute CF per symptom (CF[H,E]) for reporting
        const cfPerSymptom = {};
        for (const s of SYMPTOMS){
            if (userAnswers.hasOwnProperty(s.id)){
            const cfUser = Number(userAnswers[s.id]);
            const cfhe = calculateCFHE(s.cfPakar, cfUser);
                cfPerSymptom[s.id] = +cfhe.toFixed(6);
            } else {
                cfPerSymptom[s.id] = 0.0;
            }
        }

        // compute cluster CF
        const clusterResults = {};
        for (const clusterName of Object.keys(CLUSTERS)){
            clusterResults[clusterName] = +calculateClusterCF(clusterName, userAnswers).toFixed(6);
        }

        // overall CF
        const cfOverall = +calculateOverallCF(userAnswers).toFixed(6);
        const diagnosisId = interpretCF(cfOverall);
        const diagnosisObj = DIAGNOSES.find(d => d.id === diagnosisId) || { id: diagnosisId, name: diagnosisId };
        interpretation = CONFIG.interpretation.find(item => item.label === diagnosisId)
        min = interpretation.min;
        max = interpretation.max;

        confidence = (cfOverall - min) / (max - min);
        const percentage = 50 + (confidence * 50);

        // build detailed results
        const allClusterList = Object.keys(clusterResults).map(k => ({ cluster: k, cf: clusterResults[k] }));
        const result = {
            diagnosis: diagnosisId,
            diagnosisName: diagnosisObj.name,
            percentage: percentage,
            timestamp: Date.now(),
            cfPerSymptom,
            clusterResults: allClusterList,
            cfCombined: cfOverall,
            diagnosisObj: {
                id: diagnosisObj.id,
                name: diagnosisObj.name,
                description: diagnosisObj.description || ''
            },
            // solutions: SOLUTIONS[diagnosisObj.id] || [],
            answers: userAnswers
        };

        return result;
    }

    // =========================
    // EXAMPLE USAGE
    // =========================

    // Example userAnswers: you must supply cfUser numeric values (-1..1 or 0..1 depending UI)
    // const exampleUserAnswers = {
    // G1: 0.6,   // mis. user menjawab "Sering" -> mapped 0.6 (Likert) OR 0.6 from ANSWER_OPTIONS
    // G2: 0.6,
    // G3: 0.6,
    // G4: 0.4,
    // G5: 0.6,
    // G6: 0.4,
    // G7: 0.2,
    // G8: 0.2,
    // G18: 0.6,
    // G21: 0.6,
    // G24: 0.4
    // };

    // Untuk menjalankan diagnose:
    // const report = diagnose(exampleUserAnswers);
    // console.log(report);



    /**
     * Render clickable option buttons for a symptom.
     * Call this after you insert the innerHTML (as above).
     */
    function renderAnswerOptionsForSymptom(symptomId) {
        const container = document.getElementById(`answer-options-${symptomId}`);
        if (!container) return;
        // build buttons
        container.innerHTML = ANSWER_OPTIONS.map(opt => {
            // slider expects -100..100, so multiply
            const sliderVal = Math.round(opt.value * 100);
            const buttonLabel = isMobile ? `${sliderVal}%` : `${opt.text} (${sliderVal}%)`;
            return `
            <button
                type="button"
                class="answer-option-btn text-xs px-3 py-1 rounded-full border transition-all hover:shadow-sm"
                data-slider-value="${sliderVal}"
                data-option-value="${opt.value}"
                onclick="setSliderValueFromOption('${symptomId}', ${sliderVal})"
                aria-label="${opt.text} (${sliderVal}%)"
            >
                ${buttonLabel}
            </button>
            `;
        }).join('');

        // initial highlight according to current slider/userAnswers
        const slider = document.getElementById(`slider-input-${symptomId}`);
        const initial = slider ? Number(slider.value) : 0;
        highlightClosestOption(symptomId, initial);
    }

    /**
     * When user clicks an option -> set slider and update display & userAnswers.
     */
    function setSliderValueFromOption(symptomId, sliderValue) {
        const slider = document.getElementById(`slider-input-${symptomId}`);
        if (!slider) return;
        // slider.value = sliderValue;
        const $slider = $(`#slider-input-${symptomId}`);
        $slider.stop(true);

        $({ val: Number($slider.val()) }).animate(
            { val: Number(sliderValue) },
            {
                duration: 300,
                easing: "swing",
                step: function(now) {
                    // update slider UI
                    $slider.val(Math.round(now));

                    // update display + userAnswers
                    updateSliderValue(symptomId, Math.round(now));

                    // highlight closest option
                    highlightClosestOption(symptomId, Math.round(now));
                },
                complete: function() {
                    $slider.val(sliderValue);
                    updateSliderValue(symptomId, sliderValue);
                    highlightClosestOption(symptomId, sliderValue);
                }
            }
        );
        // updateSliderValue(symptomId, sliderValue);
        // highlightClosestOption(symptomId, sliderValue);
    }

    /**
     * Called on slider input (wired to oninput in template).
     * rawValue may be string — convert to Number.
     */
    // function updateSliderValue(symptomId, rawValue) {
    //     const percent = Number(rawValue); // -100 .. 100
    //     const display = document.getElementById(`slider-value-${symptomId}`);
    //     if (display) display.textContent = `${percent}%`;

    //     // store as -1.0 .. 1.0
    //     userAnswers = window.userAnswers || {}; // ensure global exists
    //     userAnswers[symptomId] = +(percent / 100).toFixed(2);

    //     // update highlighted option
    //     highlightClosestOption(symptomId, percent);
    // }

    /**
     * Find closest option (by slider percent) and apply an active class.
     */
    function highlightClosestOption(symptomId, percent) {
        const container = document.getElementById(`answer-options-${symptomId}`);
        if (!container) return;
        const buttons = Array.from(container.querySelectorAll('.answer-option-btn'));

        // find closest by absolute difference
        let closestBtn = null;
        let closestDiff = Infinity;
        buttons.forEach(btn => {
            const v = Number(btn.getAttribute('data-slider-value'));
            const diff = Math.abs(v - percent);
            if (diff < closestDiff) {
            closestDiff = diff;
            closestBtn = btn;
            }
        });

        buttons.forEach(btn => {
            if (btn === closestBtn) {
            btn.classList.add('bg-blue-600', 'text-white', 'border-transparent', 'shadow');
            btn.classList.remove('bg-white', 'text-gray-700');
            } else {
            btn.classList.remove('bg-blue-600', 'text-white', 'border-transparent', 'shadow');
            btn.classList.add('bg-white', 'text-gray-700');
            }
        });
    }


    // State
    let currentQuestionIndex = 0;
    let userAnswers = {};
    var riwayat = [];
    let currentResult = null;
    let currentUser = {};
    let options = {
        searchable: true
    }
    
    let n_employee_id = NiceSelect.bind(document.getElementById('employee_id'), options);

    get_employee_id();

    function get_employee_id() {
        user_id = "<?= $this->session->userdata('user_id'); ?>"
        allowed_akses = ['2063', '1', '979'];
        if (allowed_akses.includes(user_id)) {
            $.ajax({
                url: base_url + '/get_employee_id',
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    list_employee = '<option value="default" selected>All</option>';
                    for (let index = 0; index < response.length; index++) {
                        list_employee +=
                            `<option value="${response[index].user_id}">${response[index].employee_name}</option>`;
                    }

                    $("#employee_id").empty().append(list_employee);
                    n_employee_id.update()

                },
            });
        } else {
            list_employee = '<option value="default" selected>Default</option>';
            $("#employee_id").empty().append(list_employee);
            n_employee_id.update()
        }
    }

    
    

    // Navigation
    async function navigateTo(pageId) {
        const $current = $('.section.active');
        const $next = $('#' + pageId);

        if ($current.attr('id') === pageId) return;

        // Run page-specific initialization BEFORE fade-in
        if (pageId === 'questionnaire-page') {
            await initQuestionnaire();
        } 
        else if (pageId === 'history-page') {
            await loadHistory();
        }
        else if (pageId === 'landing-page') {
            await renderTestimoni();
        }

        // Fade out current section
        $current.fadeOut(200, function () {
            $current.removeClass('active');

            // Fade in next section
            $next.fadeIn(200).addClass('active');

            // Scroll to top
            $('html, body').animate({ scrollTop: 0 }, 200);
        });
    }

    // Questionnaire Functions
    async function initQuestionnaire() {
        await $.ajax({
            type: "POST",
            url: base_url + '/questionnaire',
            data: {
                //
            },
            dataType: "json",
            success: function(response) {
                // $('#id').empty();
                console.log(response);

                let data = response.data;
                let answers = response.answers;
                currentQuestionIndex = 0;
                userAnswers = {};
                if (answers.length > 0) {
                    currentQuestionIndex = answers.length - 1;
                    answers.forEach(answer => {
                        userAnswers[answer.symptom_id] = answer.cf_user;
                    });
                }
                updateQuickNavigation();
                updateQuestion();
            }
        });
    }
    window.addEventListener('beforeunload', (event) => {
        // Perform actions before the window closes, e.g., save data, confirm exit.
        // To prompt the user before closing, set the returnValue property.
        saveQuestionnaire();
        // event.preventDefault(); // Cancel the event
        // event.returnValue = 'Are you sure you want to leave?'; // Message for the user
    });
    // $(`#backHomeBtn`).on('click', function(){
    //     saveQuestionnaire();
    //     navigateTo('landing-page');
    // })
    $(document).on('click', '.save-questionnaire', function() {
        saveQuestionnaire();
        console.log($(this).attr('id'));
        navigateTo('landing-page');
    })

    function saveQuestionnaire() {
        $.ajax({
            type: "POST",
            url: base_url + '/save_questionnaire',
            data: {
                answers: userAnswers
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

            }
        });
    }

    function updateQuestion() {
        const symptom = SYMPTOMS[currentQuestionIndex];
        document.getElementById('question-text').textContent = symptom.name;
        document.getElementById('current-question-num').textContent = currentQuestionIndex + 1;
        document.getElementById('total-questions').textContent = SYMPTOMS.length;

        const progress = ((currentQuestionIndex + 1) / SYMPTOMS.length) * 100;
        document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
        document.getElementById('progress-bar').style.width = progress + '%';

        // Update answered count
        document.getElementById('answered-count').textContent = Object.keys(userAnswers).length;

        // Update quick navigation
        updateQuickNavigation();

        // Render answer options
        const answerOptionsDiv = document.getElementById('answer-options');
        console.log(`${symptom.id}` in userAnswers ? userAnswers[symptom.id] * 100 : 0);

        answerOptionsDiv.innerHTML = `
        <div class="space-y-3">
            <label class="font-medium">Seberapa yakin Anda?</label>

            <!-- Clickable options container -->
            <div id="answer-options-${symptom.id}" class="flex flex-wrap gap-2"></div>

            <!-- Slider -->
            <input
            type="range"
            min="-100"
            max="100"
            value="${`${symptom.id}` in userAnswers ? userAnswers[symptom.id]*100 : 0}"
            step="1"
            class="w-full h-2 bg-gray-200 rounded-lg cursor-pointer accent-blue-600"
            id="slider-input-${symptom.id}"
            oninput="updateSliderValue('${symptom.id}', this.value)"
            />

            <!-- Value Display -->
            <div class="flex justify-between items-center text-sm text-gray-600">
            <span class="text-xs">-100%<br>Pasti Tidak</span>
            <span id="slider-value-${symptom.id}" class="font-semibold text-blue-600">0%</span>
            <span class="text-xs">+100%<br>Pasti</span>
            </div>
        </div>
        `;
        
        /* --- Usage: after injecting the innerHTML for a given symptom --- */
        /* Example: call this right after the innerHTML assignment (for same symptom.id) */
        renderAnswerOptionsForSymptom(symptom.id);

        updateSliderValue(symptom.id, document.getElementById(`slider-input-${symptom.id}`).value);


        // ANSWER_OPTIONS.forEach(option => {
        //     const isSelected = userAnswers[symptom.id] === option.value;
        //     const optionDiv = document.createElement('div');
        //     optionDiv.className = 'flex items-center space-x-2';
        //     optionDiv.innerHTML = `
        //         <input type="radio" id="${option.text}" name="answer" value="${option.value}" 
        //                 ${isSelected ? 'checked' : ''} 
        //                 onchange="selectAnswer('${symptom.id}', ${option.value})"
        //                 class="w-4 h-4 text-blue-600">
        //         <label for="${option.text}" class="flex-1 cursor-pointer p-3 rounded-lg border border-gray-200 hover:bg-gray-50">
        //             <div class="flex items-center justify-between">
        //                 <span class="font-medium">${option.text}</span>
        //                 <span class="text-sm text-gray-500">${option.value >= 0 ? '+' : ''}${(option.value * 100).toFixed(0)}%</span>
        //             </div>
        //         </label>
        //     `;
        //     answerOptionsDiv.appendChild(optionDiv);
        // });

        // Update button states
        prevBtn = document.getElementById('prev-btn')
        prevBtnSvg = prevBtn.getElementsByTagName('svg')[0]
        prevBtnText = document.getElementById('prev-btn-text')
        nextBtn = document.getElementById('next-btn')
        nextBtnSvg = nextBtn.getElementsByTagName('svg')[0]
        nextBtnText = document.getElementById('next-btn-text')
        navBtns = document.getElementById('navigation-buttons')
        prevBtn.disabled = currentQuestionIndex === 0;
        const isLastQuestion = currentQuestionIndex === SYMPTOMS.length - 1;
        nextBtnText.textContent = isLastQuestion ? 'Selesaikan' : 'Selanjutnya';
        console.log(nextBtnSvg);
        
        if (isMobile) {
            navBtns.classList.remove('flex-col', 'space-y-3');
            navBtns.classList.add('flex-row', 'justify-between', 'items-center', 'space-y-0');
            nextBtn.classList.remove('px-4');
            nextBtn.classList.add('px-1');
            prevBtn.classList.remove('px-4');
            prevBtn.classList.add('px-1');
            nextBtnSvg.classList.remove('ml-2');
            prevBtnSvg.classList.remove('mr-2');
            nextBtnText.textContent = '';
            prevBtnText.textContent = '';
        } else {
            navBtns.classList.add('flex-col', 'space-y-3');
            navBtns.classList.remove('flex-row', 'justify-between', 'items-center', 'space-y-0');
            nextBtn.classList.add('px-4');
            nextBtn.classList.remove('px-1');
            prevBtn.classList.add('px-4');
            prevBtn.classList.remove('px-1');
            nextBtnSvg.classList.add('ml-2');
            prevBtnSvg.classList.add('mr-2');
            nextBtnText.textContent = isLastQuestion ? 'Selesaikan' : 'Selanjutnya';
            prevBtnText.textContent = 'Sebelumnya';
        }
    }

    function updateSliderValue(code, value) {
        // Convert from -100..100 → -1..1
        const cf = (value / 100).toFixed(2);

        // Update display
        document.getElementById('slider-value-' + code).innerText = value + "%";

        // Call your existing handler
        selectAnswer(code, parseFloat(cf));
        highlightClosestOption(code, value);
    }

    function updateQuickNavigation() {
        const quickNavDiv = document.getElementById('quick-navigation');
        quickNavDiv.innerHTML = '';

        SYMPTOMS.forEach((symptom, index) => {
            const isCurrent = index === currentQuestionIndex;
            const isAnswered = userAnswers[symptom.id] !== undefined;

            let bgColor = 'bg-gray-200 text-gray-600'; // Default: unanswered
            if (isCurrent) {
                bgColor = 'bg-blue-500 text-white'; // Current question
            } else if (isAnswered) {
                bgColor = 'bg-green-200 text-green-800'; // Answered
            }

            const button = document.createElement('button');
            button.className = `w-12 h-12 rounded-full ${bgColor} font-semibold hover:opacity-80 transition-all`;
            button.textContent = index + 1;
            button.onclick = () => jumpToQuestion(index);
            quickNavDiv.appendChild(button);
        });
        const activeBtn = document.querySelector(`#quick-navigation button:nth-child(${currentQuestionIndex+1})`);
        console.log(activeBtn);

        setTimeout(() => {
            activeBtn.scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest'
            });
            document.getElementById('question-text').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }, 200); // adjust delay as needed
    }

    function jumpToQuestion(index) {
        if (index >= 0 && index < SYMPTOMS.length) {
            currentQuestionIndex = index;
            updateQuestion();
            // Scroll to question card
            // document.getElementById('question-text').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function selectAnswer(symptomId, value) {
        userAnswers[symptomId] = value;
        document.getElementById('answered-count').textContent = Object.keys(userAnswers).length;
    }

    function previousQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            updateQuestion();

        }
    }

    function nextQuestion() {
        const symptom = SYMPTOMS[currentQuestionIndex];
        if (userAnswers[symptom.id] === undefined) {
            alert('Silakan pilih jawaban terlebih dahulu');
            return;
        }

        if (currentQuestionIndex < SYMPTOMS.length - 1) {
            currentQuestionIndex++;
            updateQuestion();
            // const activeBtn = document.querySelector(`#quick-navigation button:nth-child(${currentQuestionIndex})`);
            // activeBtn.scrollIntoView({
            //     behavior: 'smooth',
            //     inline: 'center',
            //     block: 'nearest'
            // });
        } else {
            // Complete questionnaire
            completeQuestionnaire();
        }
    }

    async function updateDiagnose() {
        var diagnoses;
        var answers;
        await $.ajax({
            type: "POST",
            url: base_url + '/load_diagnose',
            data: {
                user_id : 'default'
            },
            dataType: "json",
            success: function(response) {
                diagnoses = response.diagnoses;
                answers = response.answers;
            }
        });
        for (const diagnosis of diagnoses) {
            userAnswers = answers[diagnosis.id];
            const result = diagnose();

            // const response = await $.ajax({
            //     type: "POST",
            //     url: base_url + '/complete_questionnaire',
            //     data: { diagnose: result },
            //     dataType: "json",
            // });

            result.userFullname = diagnosis.full_name;
            result.departmentName = diagnosis.department_name;
            result.userId = diagnosis.user_id;
            // result.sessionId = response.session.id;
            // currentResult = result;

            console.log(result);
        }
        
    }

    function completeQuestionnaire() {
        const result = diagnose(); //a
        console.log(result);


        saveQuestionnaire();
        $.ajax({
            type: "POST",
            url: base_url + '/complete_questionnaire',
            data: {
                diagnose: result
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                result['userFullname'] = response.user.full_name;
                result['departmentName'] = response.user.department_name;
                result['sessionId'] = response.session.id;
                currentResult = result;
                displayResult(result);
                navigateTo('result-page');
            }
        });

        // Save to localStorage

        // const history = JSON.parse(localStorage.getItem('diagnosis_history') || '[]');
        // history.push(result);
        // localStorage.setItem('diagnosis_history', JSON.stringify(history));

        // Display result
    }

    function displayResult(result) {
        // Update diagnosis name and percentage
        document.getElementById('diagnosis-name').textContent = result.diagnosisName;
        document.getElementById('diagnosis-percentage').textContent = parseFloat(result.percentage).toFixed(1) + '%';
        // document.getElementById('cf-combined').textContent = parseFloat(result.cfCombined).toFixed(4);


        // Update progress bar
        document.getElementById('result-progress-bar').style.width = parseFloat(result.percentage) + '%';

        // Update emoji
        const emoji = getStressEmoji(result.diagnosis);
        document.getElementById('stress-emoji').textContent = emoji;

        // Update color
        const colorClass = getStressColor(parseFloat(result.percentage));
        document.getElementById('diagnosis-card').className = 'bg-white rounded-lg shadow p-6 border-2 ' + colorClass;

        // Update date
        document.getElementById('employee-name').textContent = result.userFullname;
        document.getElementById('employee-dept').textContent = result.departmentName;
        document.getElementById('test-date').textContent = new Date(result.timestamp).toLocaleString('id-ID');
        document.getElementById('test-id').value = result.sessionId;


        // Update solutions
        const solutions = SOLUTIONS[result.diagnosis] || [];
        const solutionsList = document.getElementById('solutions-list');
        solutionsList.innerHTML = '';

        solutions.forEach(solution => {
            const solutionDiv = document.createElement('div');
            solutionDiv.className = 'flex items-start space-x-3 p-3 bg-green-50 rounded-lg';
            solutionDiv.innerHTML = `
                <svg class="h-5 w-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-gray-700">${solution}</span>
            `;
            solutionsList.appendChild(solutionDiv);
        });
    }

    function getStressEmoji(diagnosis) {
        const emojis = {
            'D1': '😊',
            'D2': '😐',
            'D3': '😟',
            'D4': '😰'
        };
        return emojis[diagnosis] || '❓';
    }

    function getStressColor(percentage) {
        if (percentage >= 75) return 'border-red-200 bg-red-50';
        if (percentage >= 50) return 'border-orange-200 bg-orange-50';
        if (percentage >= 25) return 'border-yellow-200 bg-yellow-50';
        return 'border-green-200 bg-green-50';
    }

    function downloadResult() {
        if (!currentResult) return;

        const reportData = {
            diagnosis: currentResult,
            date: new Date(currentResult.timestamp).toLocaleString('id-ID')
        };

        const dataStr = JSON.stringify(reportData, null, 2);
        const dataUri = 'data:application/json;charset=utf-8,' + encodeURIComponent(dataStr);

        const exportFileDefaultName = `diagnosis-stress-${currentResult.timestamp}.json`;

        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();
    }

    async function loadHistory(user_id='default') {
        await $.ajax({
            type: "POST",
            url: base_url + '/load_history',
            data: {
                user_id : user_id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                riwayat = response.history;
                currentUser = response.user
                // Update statistics
                updateStatistics(riwayat);

                // Apply filters and display results
                filterHistory();
            }
        });
    }

    async function renderTestimoni() {
        await $.ajax({
            type: "POST",
            url: base_url + '/top_rate_testimoni',
            data: {
                //
            },
            dataType: "json",
            success: function(response) {
                console.log('response');
                ratings = response.ratings;
                let html = '';
                ratings.forEach(rating => {
                    stars = '';
                    for(i=1; i<=rating.rating; i++) stars += `⭐`
                    html += `
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-400">${stars}</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">${rating.full_name}</h3>
                        <p class="text-gray-500 text-sm mb-3">${rating.department_name}</p>
                        <p class="text-gray-600">"${rating.testimoni}"</p>
                    </div>`;
                })
                if (ratings.length < 2) {
                    html += `
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">Budi P.</h3>
                        <p class="text-gray-500 text-sm mb-3">Software Developer</p>
                        <p class="text-gray-600">"Metode Certainty Factor yang digunakan sangat akurat. Hasil diagnosa sesuai dengan kondisi saya dan rekomendasinya sangat membantu."</p>
                    </div>`;
                }
                if (ratings.length < 3) {
                    html += `
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">Maya R.</h3>
                        <p class="text-gray-500 text-sm mb-3">HR Director</p>
                        <p class="text-gray-600">"Dashboard admin sangat membantu untuk memantau kesehatan mental tim. Kami bisa melakukan intervensi dini sebelum burnout menjadi parah."</p>
                    </div>`;
                }
                $(`#top_rate_testimoni`).append(html)
            }
        });
    }

    function updateStatistics(riwayat) {
        const stats = {
            total: riwayat.length,
            'D1': 0,
            'D2': 0,
            'D3': 0,
            'D4': 0
        };
        console.log(riwayat);


        riwayat.forEach(result => {
            if (stats[result.diagnose_id] !== undefined) {
                stats[result.diagnose_id]++;
            }
        });

        document.getElementById('stat-total').textContent = stats.total;
        document.getElementById('stat-tidak-stres').textContent = stats['D1'];
        document.getElementById('stat-stres-rendah').textContent = stats['D2'];
        document.getElementById('stat-stres-sedang').textContent = stats['D3'];
        document.getElementById('stat-stres-tinggi').textContent = stats['D4'];
    }

    function filterHistory() {
        // const history = JSON.parse(localStorage.getItem('diagnosis_history') || '[]');

        const searchTerm = document.getElementById('search-input')?.value.toLowerCase() || '';
        const stressFilter = document.getElementById('stress-filter')?.value || '';
        const timeFilter = document.getElementById('time-filter')?.value || '';

        let filteredHistory = riwayat.filter(result => {
            // Search filter
            // const matchesSearch = !searchTerm || 
            //     result.name.toLowerCase().includes(searchTerm) ||
            //     (result.employeeName && result.employeeName.toLowerCase().includes(searchTerm));

            // Stress level filter
            const matchesStress = !stressFilter || result.diagnose_id === stressFilter;

            // Time filter
            let matchesTime = true;
            if (timeFilter) {
                const resultDate = new Date(result.started_at);
                const now = new Date();

                switch (timeFilter) {
                    case 'today':
                        matchesTime = resultDate.toDateString() === now.toDateString();
                        break;
                    case 'week':
                        const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                        matchesTime = resultDate >= weekAgo;
                        break;
                    case 'month':
                        matchesTime = resultDate.getMonth() === now.getMonth() &&
                            resultDate.getFullYear() === now.getFullYear();
                        break;
                    case 'year':
                        matchesTime = resultDate.getFullYear() === now.getFullYear();
                        break;
                }
            }
            // matchesSearch &&
            return matchesStress && matchesTime;
        });

        displayHistoryResults(filteredHistory);
    }

    function displayHistoryResults(riwayat) {
        const historyList = document.getElementById('history-list');
        const resultCount = document.getElementById('result-count');
        const averagePercentage = document.getElementById('average-percentage');
        user_id = "<?= $this->session->userdata('user_id'); ?>"
        allowed_akses = ['2063', '1', '979'];

        resultCount.textContent = riwayat.length;

        if (riwayat.length === 0) {
            averagePercentage.textContent = '0.0%';
            historyList.innerHTML = `
                <div class="flex flex-col items-center justify-center py-16">
                    <svg class="h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-gray-500 text-center mb-2">Tidak ada hasil diagnosa yang ditemukan</p>
                    <p class="text-gray-400 text-sm text-center">Coba ubah filter atau lakukan diagnosa baru</p>
                </div>
            `;
            return;
        }

        // Calculate average
        const avgPercentage = riwayat.reduce((sum, result) => sum + parseFloat(result.confidence), 0) / riwayat.length;
        averagePercentage.textContent = avgPercentage.toFixed(1) + '%';
        console.log(riwayat);
        
        // Create table
        historyList.innerHTML = '';
        const table = document.createElement('table');
        table.className = 'w-full';
        table.innerHTML = `
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                    ${ allowed_akses.includes(user_id) ? `<th class="text-left py-3 px-4 font-semibold text-gray-700">Nama</th>` : ''}
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Diagnosa</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Persentase</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        `;

        const tbody = table.querySelector('tbody');
        [...riwayat].reverse().forEach((result, index) => {
            const row = document.createElement('tr');
            row.className = 'border-b hover:bg-white cursor-pointer transition-colors';

            const colorClass = getStressColorClass(result.diagnose_id);

            row.innerHTML = `
                <td class="py-3 px-4 text-gray-600">
                    ${new Date(result.started_at).toLocaleString('id-ID', { 
                        year: 'numeric', 
                        month: 'short', 
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}
                </td>
                    ${ allowed_akses.includes(user_id) ? `<td class="py-3 px-4"> ${result.full_name} </td>` : ''}
                <td class="py-3 px-4">
                    <span class="font-medium ${colorClass}">${result.name}</span>
                </td>
                <td class="py-3 px-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="${getProgressBarColor(result.diagnose_id)} h-2 rounded-full" style="width: ${result.confidence}%"></div>
                        </div>
                        <span class="text-sm font-medium">${parseFloat(result.confidence).toFixed(1)}%</span>
                    </div>
                </td>
                <td class="py-3 px-4">
                    <span class="text-2xl">${getStressEmoji(result.diagnose_id)}</span>
                </td>
            `;

            // 👉 Tambahkan event klik di sini
            row.addEventListener('click', () => {
                console.log("Clicked row:", result); 
                // buka detail, modal, halaman lain, dll
                // contoh:
                // openDetailModal(result);
                result['diagnosisName'] = result['name']
                result['diagnosis'] = result['diagnose_id']
                result['percentage'] = result['confidence']
                result['cfCombined'] = result['cf_combined']
                result['timestamp'] = result['completed_at']
                result['userFullname'] = result['full_name'];
                result['departmentName'] = result['department_name'];
                displayResult(result);
                navigateTo('result-page');
            });

            tbody.appendChild(row);
        });

        historyList.appendChild(table);
    }

    function getStressColorClass(diagnosis) {
        const colors = {
            'D1': 'text-green-600',
            'D2': 'text-yellow-600',
            'D3': 'text-orange-600',
            'D4': 'text-red-600'
        };
        return colors[diagnosis] || 'text-gray-600';
    }

    function getProgressBarColor(diagnosis) {
        const colors = {
            'D1': 'bg-green-600',
            'D2': 'bg-yellow-500',
            'D3': 'bg-orange-500',
            'D4': 'bg-red-600'
        };
        return colors[diagnosis] || 'bg-blue-600';
    }

    function resetFilters() {
        // document.getElementById('search-input').value = '';
        document.getElementById('stress-filter').value = '';
        document.getElementById('time-filter').value = '';
        filterHistory();
    }

    function exportHistory() {
        // const history = JSON.parse(localStorage.getItem('diagnosis_history') || '[]');

        if (riwayat.length === 0) {
            alert('Tidak ada data untuk diekspor');
            return;
        }

        const dataStr = JSON.stringify(riwayat, null, 2);
        const dataUri = 'data:application/json;charset=utf-8,' + encodeURIComponent(dataStr);

        const exportFileDefaultName = `riwayat-diagnosa-${Date.now()}.json`;

        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a saved state
        navigateTo('landing-page');
    });

    $(document).ready(async function() {
        $('body').addClass('menu-close');
        await initMasterData();
    });
    
    async function initMasterData() {
        await $.ajax({
            type: "POST",
            url: base_url + '/master_data',
            data: {
                //
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                diagnoses = response.diagnoses;
                DIAGNOSES = diagnoses;
                symptoms = response.symptoms;
                SYMPTOMS = symptoms.map(item => ({
                    ...item,
                    cfPakar: parseFloat(item.cfPakar)
                }));
                solutions = response.solutions;
                solutions.forEach(solution => {
                    if (`${solution.id}` in SOLUTIONS){
                        SOLUTIONS[solution.id].push(solution.solution);
                    } else {
                        SOLUTIONS[solution.id] = [solution.solution];
                    }
                })
                rules = response.rules;
                rules.forEach(rule => {
                    RULES[rule.id] = rule.rules.split(',');
                })
                renderTestimoni();
            }
        });
    }
</script>
<script>
    const menuButton = document.getElementById("mobile-menu-button");
    const menuPanel = document.getElementById("mobile-menu-panel");

    menuButton.addEventListener("click", () => {
        menuPanel.classList.toggle("hidden");
    });
</script>
<script>
    (function() {
        const modal = document.getElementById('modal_rate_testimoni');
        const backdrop = modal.querySelector('.modal-backdrop');
        const closeBtn = document.getElementById('modalCloseBtn');
        const openBtn = document.querySelector('.open-modal-btn');
        const stars = Array.from(document.querySelectorAll('#starsContainer .star'));
        const ratingText = document.getElementById('ratingText');
        const feedbackForm = document.getElementById('feedbackForm');
        const formView = document.getElementById('formView');
        const successView = document.getElementById('successView');
        const aiResponseText = document.getElementById('aiResponseText');
        const resetBtn = document.getElementById('resetBtn');
        const errorMessage = document.getElementById('errorMessage');

        let selectedRating = 0;

        // Rating labels
        const labels = {
            0: '',
            1: 'Very bad',
            2: 'Not great',
            3: 'Okay',
            4: 'Good',
            5: 'Excellent'
        };

        openBtn.addEventListener("click", openModal);

        closeBtn.addEventListener("click", closeModal);
        //   cancelBtn.addEventListener("click", closeModal);
        backdrop.addEventListener("click", closeModal);
        //   successCloseBtn.addEventListener("click", closeModal);

        function openModal() {
            modal.classList.remove('hidden');
            // trap focus: focus first input
            //   setTimeout(() => document.getElementById('name').focus(), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            resetFormState();
        }

        // Update visual stars for a given rating (0..5)
        function renderStars(r) {
            stars.forEach(s => {
                const value = Number(s.dataset.rating);
                if (value <= r) {
                    s.classList.remove('empty');
                    s.classList.add('filled');
                    s.setAttribute('aria-checked', 'true');
                    s.querySelector('svg').classList.add('text-yellow-400');
                } else {
                    s.classList.remove('filled');
                    s.classList.add('empty');
                    s.setAttribute('aria-checked', 'false');
                    s.querySelector('svg').classList.remove('text-yellow-400');
                }
            });
            ratingText.textContent = labels[r] || `${r}/5`;
        }
        let leaveTimeout = null;
        // Mouse interactions
        stars.forEach(s => {
            const val = Number(s.dataset.rating);

            s.addEventListener('mouseenter', () => {
                // Clear pending timeout if user re-enters quickly
                clearTimeout(leaveTimeout);
                renderStars(val);
            });

            s.addEventListener('mouseleave', () => {
                // Add delay before restoring selectedRating
                leaveTimeout = setTimeout(() => {
                    renderStars(selectedRating);
                }, 150); // delay in ms (adjust as needed)
            });

            s.addEventListener('click', () => {
                selectedRating = val;
                renderStars(selectedRating);
            });

            // keyboard select (Enter / Space)
            s.addEventListener('keydown', (ev) => {
                if (ev.key === 'Enter' || ev.key === ' ') {
                    ev.preventDefault();
                    selectedRating = val;
                    renderStars(selectedRating);
                }
            });
        });

        // Form submit (simulated). Replace with real endpoint if needed.
        feedbackForm.addEventListener('submit', (e) => {
            e.preventDefault();
            errorMessage.classList.add('hidden');

            // Basic validation
            const name = document.getElementById('employee-name').textContent;
            const comment = feedbackForm.comment.value.trim();
            const sessionId = document.getElementById(`test-id`).value.trim();

            if (!comment || selectedRating === 0) {
                errorMessage.textContent = 'Mohon isikan rating dan testimoni anda.';
                errorMessage.classList.remove('hidden');
                return;
            }

            // show a small loading state
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" stroke-linecap="round" fill="none"></circle></svg><span> Sending</span>';
            
            // Simulate API processing then show success
            $.ajax({
                type: "POST",
                url: base_url + '/rate_testimoni',
                data: {
                    sessionId: sessionId, 
                    comment: comment,
                    rating: selectedRating  
                },
                dataType: "json",
                // headers: headers,
                success: function(response) {
                    // Asumsikan response memiliki { success: true/false, message: "...", data: {...} }
                    if (response && response.success) {
                        // Tampilkan success view
                        formView.classList.add('hidden');
                        successView.classList.remove('hidden');

                        // Buat balasan singkat tim berdasarkan input user
                        const shortReply = generateTeamReply({
                            name: name,
                            rating: selectedRating,
                            comment: comment
                        });
                        aiResponseText.innerHTML = shortReply;

                        // Scroll to success view
                        successView.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        // Tampilkan pesan error dari server jika ada, atau pesan default
                        const msg = response && response.message ? response.message : 'Terjadi kesalahan, silakan coba lagi.';
                        errorMessage.textContent = msg;
                        errorMessage.classList.remove('hidden');
                    }
                },
                error: function(xhr, status, err) {
                    // Handle network / server error
                    console.error('AJAX error', status, err);
                    errorMessage.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                    errorMessage.classList.remove('hidden');
                },
                complete: function() {
                    // Kembalikan tombol ke kondisi semula (selalu berjalan setelah success/error)
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        });

        // Reset to initial state to allow another submission
        resetBtn.addEventListener('click', () => {
            resetFormState();
            formView.classList.remove('hidden');
            successView.classList.add('hidden');
            document.getElementById('name').focus();
        });

        // backdrop / close handlers
        backdrop.addEventListener('click', (e) => {
            if (e.target.dataset.close !== undefined || e.target === backdrop) closeModal();
        });
        closeBtn.addEventListener('click', closeModal);

        // Esc to close
        document.addEventListener('keydown', (ev) => {
            if (ev.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
        });

        // Helper: generate a brief team reply
        function generateTeamReply({
            name,
            rating,
            comment
        }) {
            const greetings = name ? `Hai ${name},` : 'Hai,';
            const tone = rating >= 4 
                ? "Terima kasih atas apresiasinya — kami senang Anda memiliki pengalaman yang baik!"
                : rating === 3 
                    ? "Terima kasih atas kejujurannya — kami akan terus meningkatkan layanan."
                    : "Kami turut menyesal mendengarnya — kami akan meninjau apa yang mungkin kurang.";
            const reply = `${greetings} ${tone} <em>"${comment.length > 120 ? comment.slice(0, 117) + '…' : comment}"</em>`;
            return reply;
        }

        // reset form values & rating
        function resetFormState() {
            feedbackForm.reset();
            selectedRating = 0;
            renderStars(0);
            errorMessage.classList.add('hidden');
            // ensure formView visible, successView hidden (in case closing mid-state)
            formView.classList.remove('hidden');
            successView.classList.add('hidden');
        }

        // Expose openModal for external triggers
        window.openFeedbackModal = openModal;
        window.closeFeedbackModal = closeModal;

        // initialize
        resetFormState();
    })();
</script>
<script>
    // Placeholder function for navigation (assumed from the original code)
    (function() {
        // --- Article Data (In Indonesian) ---
        const articles = {
            'burnout': {
                title: "Apa Itu Burnout dan Bagaimana Mengenalinya?",
                tag: "Tentang Burnout",
                level: "Pemula",
                duration: "5 menit",
                imageUrl: "", // Example image
                content: `
                    <p><strong>Burnout</strong> didefinisikan oleh Organisasi Kesehatan Dunia (WHO) sebagai sindrom yang diakibatkan oleh stres kerja kronis yang belum berhasil dikelola.</p>
                    <p>Kondisi ini ditandai oleh tiga dimensi utama:</p>
                    <ol class="list-decimal list-inside pl-4 mt-2 space-y-2">
                        <li><strong>Kelelahan Energi (Exhaustion):</strong> Merasa lelah secara fisik dan emosional terus-menerus, bahkan setelah tidur atau istirahat.</li>
                        <li><strong>Jarak Mental dari Pekerjaan (Cynicism):</strong> Perasaan negatif atau sinis terhadap pekerjaan, termasuk hilangnya minat atau motivasi.</li>
                        <li><strong>Penurunan Efektivitas Profesional (Reduced Efficacy):</strong> Penurunan rasa pencapaian dan kompetensi dalam pekerjaan.</li>
                    </ol>
                    <h4 class="text-xl font-semibold mt-4 mb-2 text-gray-800">Cara Mengenali Gejala Burnout</h4>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>Sering sakit kepala, gangguan tidur, atau masalah pencernaan yang tidak bisa dijelaskan.</li>
                        <li>Mudah marah, frustrasi, atau merasa kewalahan tanpa alasan jelas.</li>
                        <li>Menghindari tugas atau tanggung jawab yang dulunya dinikmati.</li>
                        <li>Merasa tidak dihargai atau tidak ada gunanya upaya Anda di tempat kerja.</li>
                    </ul>
                    <p class="mt-4 italic">Jika Anda mengalami beberapa gejala ini secara konsisten selama berminggu-minggu, pertimbangkan untuk mengambil jeda atau berkonsultasi dengan profesional kesehatan mental.</p>
                    <p class="mt-4">Untuk memastikan pengguliran berfungsi, kami menambahkan sedikit lebih banyak konten di sini. Mengelola kesehatan mental secara proaktif adalah investasi, bukan pengeluaran.</p>
                `
            },
            'relaksasi': {
                title: "10 Teknik Relaksasi untuk Mengurangi Stres",
                tag: "Manajemen Stres",
                level: "Pemula",
                duration: "7 menit",
                videoUrl: "", // Example YouTube video
                content: `
                    <p>Mengelola stres adalah kunci untuk mencegah burnout. Berikut adalah sepuluh teknik relaksasi sederhana yang dapat Anda praktikkan di mana saja:</p>
                    <ol class="list-decimal list-inside pl-4 mt-2 space-y-3">
                        <li><strong>Pernapasan Diafragma:</strong> Tarik napas perlahan melalui hidung, kembungkan perut, tahan sebentar, lalu hembuskan perlahan melalui mulut. Ulangi 10 kali.</li>
                        <li><strong>Relaksasi Otot Progresif (PMR):</strong> Tegangkan dan rilekskan setiap kelompok otot dalam tubuh Anda (mulai dari kaki hingga kepala) secara berurutan.</li>
                        <li><strong>Meditasi Singkat:</strong> Duduk diam selama 5 menit, fokus hanya pada napas Anda. Biarkan pikiran datang dan pergi tanpa menghakimi.</li>
                        <li><strong>Visualisasi Positif:</strong> Bayangkan tempat yang menenangkan (pantai, hutan) secara detail selama beberapa menit.</li>
                        <li><strong>Mindfulness (Kesadaran Penuh):</strong> Fokus sepenuhnya pada satu aktivitas saat ini, seperti mencuci piring atau minum kopi.</li>
                        <li><strong>Istirahat 5 Menit (Micro-breaks):</strong> Setiap jam, berdiri, regangkan badan, dan alihkan pandangan dari layar.</li>
                        <li><strong>Journaling (Menulis Jurnal):</strong> Tuliskan semua pikiran atau kekhawatiran yang membebani Anda sebelum tidur.</li>
                        <li><strong>Aromaterapi:</strong> Gunakan minyak esensial seperti lavender atau peppermint saat bekerja atau bersantai.</li>
                        <li><strong>Mendengarkan Musik:</strong> Putar musik instrumental yang menenangkan untuk memblokir kebisingan yang mengganggu.</li>
                        <li><strong>Gerakan Ringan:</strong> Lakukan peregangan leher, bahu, dan punggung di meja kerja Anda untuk melepaskan ketegangan fisik.</li>
                    </ol>
                    <p class="mt-4">Video di atas menunjukkan beberapa latihan pernapasan yang bisa Anda coba.</p>
                `
            },
            'keseimbangan': {
                title: "Menjaga Keseimbangan Kerja-Hidup di Era Digital",
                tag: "Tips Sehat",
                level: "Menengah",
                duration: "6 menit",
                imageUrl: "", // Example image
                content: `
                    <p>Era digital telah mengaburkan batas antara pekerjaan dan kehidupan pribadi. Menjaga keseimbangan (Work-Life Balance) membutuhkan strategi yang terencana.</p>
                    <h4 class="text-xl font-semibold mt-4 mb-2 text-gray-800">Strategi Utama: Batasan Digital</h4>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li><strong>Atur Waktu Non-Kerja:</strong> Tetapkan waktu yang jelas (misalnya, setelah jam 6 sore) di mana Anda tidak akan memeriksa email atau pesan kerja.</li>
                        <li><strong>Nonaktifkan Notifikasi:</strong> Matikan notifikasi aplikasi kerja di ponsel pribadi Anda di luar jam kerja.</li>
                        <li><strong>Gunakan Dua Perangkat:</strong> Jika memungkinkan, pisahkan perangkat kerja (laptop/ponsel) dengan perangkat pribadi.</li>
                        <li><strong>Time Blocking:</strong> Alokasikan waktu spesifik di kalender Anda, tidak hanya untuk tugas kerja, tetapi juga untuk olahraga, hobi, dan keluarga.</li>
                        <li><strong>'Penutupan' Hari Kerja:</strong> Lakukan ritual singkat di akhir hari kerja (misalnya, merapikan meja, membuat daftar tugas besok) sebagai sinyal mental bahwa pekerjaan telah selesai.</li>
                    </ul>
                    <p class="mt-4">Keseimbangan bukan berarti membagi waktu 50/50, tetapi memastikan Anda memiliki energi dan waktu yang memadai untuk peran-peran penting di luar pekerjaan.</p>
                    <p>Gambar di atas menggambarkan pentingnya mencapai harmoni dalam hidup Anda.</p>
                `
            }
        };

        // --- Modal Control Functions ---

        const modal = document.getElementById('article-modal');
        const modalTitle = modal.getElementsByClassName('modal-title')[0];
        const modalTag = modal.getElementsByClassName('modal-tag')[0];
        const modalLevel = modal.getElementsByClassName('modal-level')[0];
        const modalDuration = modal.getElementsByClassName('modal-duration')[0];
        const modalContent = modal.getElementsByClassName('modal-content')[0];

        /**
         * Opens the article modal with content corresponding to the given ID.
         * @param {string} articleId - The key for the article in the 'articles' object.
         */
                
        document.querySelectorAll('.article-card').forEach(card => {
            card.addEventListener("click", function(e) {
                const articleId = this.dataset.articleId;
                openArticleModal(articleId);
            });
        });

        document.querySelectorAll('.closeArticleModal').forEach(button => {
            button.addEventListener("click", closeArticleModal);
        });
        
        function openArticleModal(articleId) {
            const article = articles[articleId];

            if (!article) {
                console.error("Article not found for ID:", articleId);
                modalTitle.textContent = "Kesalahan!";
                modalContent.innerHTML = "<p>Artikel yang Anda cari tidak dapat ditemukan.</p>";
                modal.classList.remove('hidden');
                return;
            }
            
            // Clear previous content
            modalContent.innerHTML = '';

            // Add Image if available
            if (article.imageUrl) {
                const imgElement = document.createElement('img');
                imgElement.src = article.imageUrl;
                imgElement.alt = article.title;
                imgElement.classList.add('w-full', 'h-auto', 'rounded-lg', 'mb-6', 'shadow-md');
                modalContent.appendChild(imgElement);
            }

            // Add Video if available
            if (article.videoUrl) {
                const videoContainer = document.createElement('div');
                videoContainer.classList.add('relative', 'w-full', 'pt-[56.25%]', 'mb-6', 'rounded-lg', 'overflow-hidden', 'shadow-md'); // 16:9 aspect ratio
                const iframeElement = document.createElement('iframe');
                iframeElement.src = article.videoUrl;
                iframeElement.setAttribute('frameborder', '0');
                iframeElement.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                iframeElement.setAttribute('allowfullscreen', '');
                iframeElement.classList.add('absolute', 'top-0', 'left-0', 'w-full', 'h-full');
                videoContainer.appendChild(iframeElement);
                modalContent.appendChild(videoContainer);
            }

            // Populate Modal Content
            modalTitle.textContent = article.title;
            modalTag.textContent = article.tag;
            modalLevel.textContent = article.level;
            modalDuration.textContent = '⏱ ' + article.duration;
            modalContent.innerHTML += article.content; // Append article text content

            // Set dynamic tag color (Optional: adjust based on tag)
            if (article.tag.includes('Burnout')) {
                modalTag.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800';
            } else if (article.tag.includes('Stres')) {
                modalTag.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800';
            } else if (article.tag.includes('Sehat')) {
                modalTag.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800';
            }

            // Show Modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling the main body
        }

        /**
         * Closes the article modal.
         */
        function closeArticleModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scrolling
            // Stop video when modal closes (important for user experience)
            const iframe = modalContent.querySelector('iframe');
            if (iframe) {
                iframe.src = ''; // This stops the video
            }
        }

        // Close modal when clicking outside of it
        modal.addEventListener('click', (e) => {
            // Check if the click occurred on the overlay, not the content
            if (e.target === modal) {
                closeArticleModal();
            }
        });
    })();
    function addNewArticle(){
        $(`#main-education-page`).hide()
        $(`#add-article-page`).fadeIn(200);
        initArticleEditor()
    }
</script>

<script>
    function initArticleEditor() {
        // --- Application State ---
        let articleContent = [];
        // activeElement now tracks the element being edited in the modal
        let activeElement = { rowId: null, colId: null, elementId: null, type: null };
    
        const STORAGE_KEY = 'articleBuilderContent';
        
        // Fallback for UUID generation if crypto is not available
        const generateId = () => Date.now().toString(36) + Math.random().toString(36).substring(2);

        // Default placeholder content for new elements
        const PLACEHOLDERS = {
            TEXT: "Click here to start typing your paragraph...",
            H1: "Title",
            H2: "Heading",
            H3: "A Sub-Heading",
            IMAGE: "https://placehold.co/600x400/3b82f6/ffffff?text=Placeholder+Image+(URL)",
            VIDEO: "https://www.youtube.com/embed/dQw4w9WgXcQ?controls=0" // Example Rickroll embed
        };

        function saveArticleContent() {
            try {
                const serializedContent = JSON.stringify(articleContent);
                localStorage.setItem(STORAGE_KEY, serializedContent);
                console.log("Article content saved successfully to local storage.");
            } catch (error) {
                console.error("Could not save content:", error);
            }
        }

        function loadArticleContent() {
            try {
                const serializedContent = localStorage.getItem(STORAGE_KEY);
                if (serializedContent) {
                    const loadedContent = JSON.parse(serializedContent);
                    if (loadedContent.length > 0) {
                        articleContent = loadedContent;
                        console.log("Article content loaded from local storage.");
                    }
                }
            } catch (error) {
                console.error("Could not load content:", error);
            }
        }
        document.querySelector('.saveAndPreviewArticle').addEventListener("click", saveAndPreviewArticle);
        function saveAndPreviewArticle() {
            saveArticleContent();
            const previewHtml = renderArticleForPreview(articleContent);
            document.getElementById('preview-content').innerHTML = previewHtml;

            // Set the title of the preview modal dynamically from the first H1 element if it exists
            const firstH1Element = articleContent[0]?.columns[0]?.elements.find(el => el.type === 'H1');
            const previewTitle = firstH1Element ? firstH1Element.content : 'Article Preview';
            document.querySelector('#article-modal .modal-title').innerHTML = previewTitle;

            openArticleModal();
        }

        // --- Content Management Functions (Refactored) ---
        /**
         * Adds a new row definition to the articleContent state.
         * @param {number} colCount - Number of columns (1, 2, or 3).
         */
        document.querySelectorAll('.add-row-columns').forEach(button => {
            button.addEventListener("click", function(e) {
                const addRow = this.dataset.addRow;
                addRowArticle(addRow);
            });
        });

        function addRowArticle(colCount) {
            const rowId = generateId();
            const newRow = {
                id: rowId,
                columns: []
            };
            // The columns are always full width on small screens and use these classes on md and up
            const colClass = { 1: 'w-full', 2: 'md:w-1/2', 3: 'md:w-1/3' }[colCount];

            for (let i = 0; i < colCount; i++) {
                newRow.columns.push({
                    id: generateId(),
                    colClass: colClass,
                    elements: [] // New: Column now holds an array of elements
                });
            }
            articleContent.push(newRow);
            renderEditor();
        }

        /**
         * Deletes a row from the articleContent state.
         * @param {string} rowId - The ID of the row to delete.
         */
        function deleteRowArticle(rowId) {
            if (!confirm('Are you sure you want to delete this entire row? This cannot be undone.')) return;
            articleContent = articleContent.filter(row => row.id !== rowId);
            renderEditor();
        }

        /**
         * Adds a new content element to a specific column.
         * @param {string} rowId 
         * @param {string} colId 
         * @param {string} type - 'TEXT', 'H1', 'H2', 'IMAGE', or 'VIDEO'.
         */
        function addElementArticle(rowId, colId, type) {
            const row = articleContent.find(r => r.id === rowId);
            const column = row?.columns.find(c => c.id === colId);
            
            if (column) {
                const newElement = {
                    id: generateId(),
                    type: type,
                    // For media types, default source type is URL
                    sourceType: (type === 'IMAGE' || type === 'VIDEO') ? 'URL' : null, 
                    content: PLACEHOLDERS[type] || PLACEHOLDERS.TEXT
                };
                column.elements.push(newElement);
                renderEditor();
            }
        }

        /**
         * Deletes an element from a specific column.
         * @param {string} rowId 
         * @param {string} colId 
         * @param {string} elementId 
         */
        function deleteElementArticle(rowId, colId, elementId) {
            if (!confirm('Are you sure you want to delete this content block?')) return;

            const row = articleContent.find(r => r.id === rowId);
            const column = row?.columns.find(c => c.id === colId);

            if (column) {
                column.elements = column.elements.filter(el => el.id !== elementId);
                renderEditor();
            }
        }

        /**
         * Updates the text content of an element in the state. (Used for contenteditable)
         * @param {string} rowId 
         * @param {string} colId 
         * @param {string} elementId
         * @param {string} content - The new innerHTML of the element.
         */
        function updateElementContentArticle(rowId, colId, elementId, content) {
            const row = articleContent.find(r => r.id === rowId);
            const column = row?.columns.find(c => c.id === colId);
            const element = column?.elements.find(el => el.id === elementId);

            if (element) {
                element.content = content;
            }
            
            // Save automatically on text blur/change
            saveArticleContent();
        }


        // --- Modal Functions for URL/Upload Editing ---

        /**
         * Opens the modal for editing Image or Video content.
         * @param {string} rowId 
         * @param {string} colId 
         * @param {string} elementId 
         * @param {string} type - 'IMAGE' or 'VIDEO'.
         * @param {string} currentSource - The current URL/embed source.
         * @param {string} sourceType - 'URL' or 'UPLOAD'.
         */
        const modal = document.getElementById('content-modal');
        const modalTitle = modal.querySelector('.modal-title');
        const modalInput = modal.querySelector('.modal-input');
        const urlRadio = modal.querySelector('.source-url');
        const uploadRadio = modal.querySelector('.source-upload');
        const uploadSection = modal.querySelector('.upload-section');
        const urlSection = modal.querySelector('.url-section');
        const editor = document.getElementById('article-editor');
        
        function openModalForContentArticle(rowId, colId, elementId, type, currentSource, sourceType) {
            activeElement = { rowId, colId, elementId, type };

            modalTitle.textContent = `Edit ${type} Source`;
            
            // Set current source type and update UI
            if (sourceType === 'UPLOAD') {
                uploadRadio.checked = true;
            } else { // Default to URL
                urlRadio.checked = true;
            }
            
            // Ensure the correct input/placeholder is visible
            handleSourceTypeChange(sourceType);

            // Set the current URL if we are in URL mode
            if (sourceType === 'URL') {
                modalInput.value = currentSource;
                modalInput.placeholder = `Enter ${type === 'IMAGE' ? 'Image' : 'Video Embed'} URL...`;
            } else {
                modalInput.value = '';
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        /**
         * Handles the change of source type (URL/Upload) inside the modal.
         */
        document.querySelectorAll('.content-source-type').forEach(radio => {
            radio.addEventListener("click", function(e) {
                const sourceType = this.dataset.sourceType;
                handleSourceTypeChange(sourceType);
            });
        });
        
        function handleSourceTypeChange(type) {

            if (type === 'UPLOAD' || uploadRadio.checked) {
                urlSection.classList.add('hidden');
                uploadSection.classList.remove('hidden');
            } else {
                urlSection.classList.remove('hidden');
                uploadSection.classList.add('hidden');
            }
        }


        /**
         * Saves the content from the modal input back to the state.
         */
        document.getElementById('saveModalContent').addEventListener("click", saveModalContent);
        function saveModalContent() {
            const { rowId, colId, elementId, type } = activeElement;
            const sourceType = urlRadio.checked ? 'URL' : 'UPLOAD';

            const row = articleContent.find(r => r.id === rowId);
            const column = row?.columns.find(c => c.id === colId);
            const element = column?.elements.find(el => el.id === elementId);

            if (!element) return;
            
            element.sourceType = sourceType;

            if (sourceType === 'URL') {
                const newContent = modalInput.value.trim();
                if (!newContent) {
                    alert('Please enter a valid URL.');
                    return;
                }
                element.content = newContent;
            } else {
                // UPLOAD selected: Simulation with a specific placeholder URL.
                const uploadPlaceholder = `https://placehold.co/600x400/9333ea/ffffff?text=${type}+Uploaded+File+Simulated`;
                element.content = uploadPlaceholder;
            }

            closeModal();
            saveArticleContent(); // Save after updating content
            renderEditor();
        }

        /**
         * Closes the content modal.
         */
        document.getElementById('closeModalContent').addEventListener("click", closeModal);
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            activeElement = { rowId: null, colId: null, elementId: null, type: null };
        }


        // --- Rendering Functions (Refactored) ---

        /**
         * Generates the HTML for a single content element (P, H1, H2, IMG, VIDEO).
         * @param {string} rowId 
         * @param {string} colId 
         * @param {object} element - The element object from state.
         * @returns {string} HTML string for the element's content.
         */
        function renderElement(rowId, colId, element) {
            const { id, type, content, sourceType } = element;
            
            let elementHtml = '';
            const wrapperClasses = "relative group mb-4 p-4 rounded-lg bg-white border border-gray-200 transition duration-150 shadow-sm";

            // 1. Element Management Toolbar (Delete Button)
            const deleteButton = `
                <button onclick="deleteElementArticle('${rowId}', '${colId}', '${id}')" title="Delete Content Block"
                        class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition duration-200 hover:bg-red-600 shadow-md z-10">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            `;

            if (type === 'TEXT' || type === 'H1' || type === 'H2' || type === 'H3') {
                let tag = 'p';
                let textClasses = "text-gray-700 leading-relaxed";
                
                if (type === 'H1') { tag = 'h1'; textClasses = 'text-3xl font-bold text-gray-800 mb-2 mt-2'; } 
                else if (type === 'H2') { tag = 'h3'; textClasses = 'text-2xl font-bold text-gray-800 mb-2 mt-2'; } 
                else if (type === 'H3') { tag = 'h4'; textClasses = 'text-xl font-semibold text-gray-800 mb-1 mt-1'; }

                elementHtml = `
                    <div id="element-${id}" class="w-full">
                        <${tag} contenteditable="true"
                            class="${textClasses} focus:ring-blue-500 focus:ring-2 p-2 rounded-lg"
                            onblur="updateElementContentArticle('${rowId}', '${colId}', '${id}', this.innerHTML)"
                        >
                            ${content}
                        </${tag}>
                    </div>
                `;
                return `<div class="${wrapperClasses}">${deleteButton}${elementHtml}</div>`;

            } 
            
            else if (type === 'IMAGE') {
                const url = content;
                elementHtml = `
                    <div class="relative w-full overflow-hidden">
                        <img src="${url}" alt="Article Image" class="w-full h-auto rounded-lg object-cover" 
                            onerror="this.src='https://placehold.co/600x400/f87171/ffffff?text=Error:+Invalid+Source'" />
                        <button onclick="openModalForContentArticle('${rowId}', '${colId}', '${id}', 'IMAGE', '${url}', '${sourceType}')" 
                                class="absolute inset-0 bg-black bg-opacity-50 text-white opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center p-4">
                            <i data-lucide="image-plus" class="w-6 h-6 mr-2"></i>
                            Change Image Source (${sourceType})
                        </button>
                    </div>
                `;
                return `<div class="${wrapperClasses} bg-gray-100">${deleteButton}${elementHtml}</div>`;
            }

            else if (type === 'VIDEO') {
                const embedUrl = content;
                elementHtml = `
                    <div class="relative w-full overflow-hidden" style="padding-bottom: 56.25%; height: 0;">
                        <iframe src="${embedUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen 
                                class="absolute top-0 left-0 w-full h-full rounded-lg"
                                onerror="this.src='about:blank'; this.parentElement.innerHTML='<div class=\\"w-full h-full flex items-center justify-center text-white text-sm\\">Error loading video. Check embed URL.</div>';"></iframe>
                        <button onclick="openModalForContentArticle('${rowId}', '${colId}', '${id}', 'VIDEO', '${embedUrl}', '${sourceType}')" 
                                class="absolute inset-0 bg-black bg-opacity-50 text-white opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center p-4">
                            <i data-lucide="film" class="w-6 h-6 mr-2"></i>
                            Change Video Source (${sourceType})
                        </button>
                    </div>
                `;
                return `<div class="${wrapperClasses} bg-gray-100">${deleteButton}${elementHtml}</div>`;
            }
            
            return `<div class="p-4 bg-red-100 text-red-600 rounded-lg">Unknown Content Type: ${type}</div>`;
        }

        /**
         * Renders the full content of a single column, including all its elements and the "Add Content" button.
         * @param {object} column - The column object.
         * @param {string} rowId - ID of the parent row.
         * @returns {string} HTML string for the column.
         */
        function renderColumn(column, rowId) {
            const { id: colId, colClass, elements } = column;
            
            const elementsHtml = elements.map(element => renderElement(rowId, colId, element)).join('');

            return `
                <div class="${colClass} px-2 mb-4 w-full">
                    <div class="column-container p-2 bg-gray-100 rounded-lg border border-gray-200">
                        ${elementsHtml}
                        
                        <!-- Add Content Toolbar -->
                        <div class="flex flex-wrap gap-2 justify-center p-3 mt-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <!-- <span class="text-sm font-medium text-gray-500 mr-2">Add Content:</span> -->
                            <button onclick="addElementArticle('${rowId}', '${colId}', 'TEXT')" title="Paragraph Text" class="text-xs px-2 py-1.5 rounded-md bg-green-500 text-white hover:bg-green-600 transition duration-100 shadow-sm">
                                <i data-lucide="pilcrow" class="w-4 h-4 inline-block mr-1"></i> Text
                            </button>
                            <button onclick="addElementArticle('${rowId}', '${colId}', 'H1')" title="Main Header (H1)" class="text-xs px-2 py-1.5 rounded-md bg-purple-600 text-white hover:bg-purple-700 transition duration-100 shadow-sm">
                                <i data-lucide="heading-1" class="w-4 h-4 inline-block mr-1"></i> H1
                            </button>
                            <button onclick="addElementArticle('${rowId}', '${colId}', 'H2')" title="Large Header (H2)" class="text-xs px-2 py-1.5 rounded-md bg-purple-500 text-white hover:bg-purple-600 transition duration-100 shadow-sm">
                                <i data-lucide="heading-2" class="w-4 h-4 inline-block mr-1"></i> H2
                            </button>
                            <button onclick="addElementArticle('${rowId}', '${colId}', 'H3')" title="Sub Header (H3)" class="text-xs px-2 py-1.5 rounded-md bg-purple-400 text-white hover:bg-purple-500 transition duration-100 shadow-sm">
                                <i data-lucide="heading-3" class="w-4 h-4 inline-block mr-1"></i> H3
                            </button>
                            <button onclick="addElementArticle('${rowId}', '${colId}', 'IMAGE')" title="Image" class="text-xs px-2 py-1.5 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition duration-100 shadow-sm">
                                <i data-lucide="image" class="w-4 h-4 inline-block mr-1"></i> Image
                            </button>
                            <button onclick="addElementArticle('${rowId}', '${colId}', 'VIDEO')" title="Video Embed" class="text-xs px-2 py-1.5 rounded-md bg-red-500 text-white hover:bg-red-600 transition duration-100 shadow-sm">
                                <i data-lucide="video" class="w-4 h-4 inline-block mr-1"></i> Video
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        /**
         * Main rendering function: wipes and redraws the editor content.
         */
        function renderEditor() {
            if (!editor) return;

            editor.innerHTML = articleContent.map(row => {
                return `
                    <div class="relative group bg-transparent">
                        <!-- Row Management Controls -->
                        <div class="absolute top-0 right-0 z-20 opacity-0 group-hover:opacity-100 transition duration-200">
                            <button onclick="deleteRowArticle('${row.id}')" title="Delete Row" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-lg text-sm font-medium">
                                <i data-lucide="trash-2" class="w-4 h-4 inline-block mr-1"></i> Delete Row
                            </button>
                        </div>

                        <!-- Column Grid -->
                        <div class="flex flex-wrap -mx-2 mt-4">
                            ${row.columns.map(column => renderColumn(column, row.id)).join('')}
                        </div>
                        <div class="border-t border-gray-300 my-6"></div>
                    </div>
                `;
            }).join('');
            
            // Re-initialize Lucide Icons after rendering new HTML
            lucide.createIcons();
        }

        /**
         * Renders the full article content into clean HTML for the preview modal.
         * @param {Array} articleData - The articleContent array.
         * @returns {string} The complete, clean HTML for the article body.
         */
        function renderArticleForPreview(articleData) {
            let previewHtml = '';
            
            articleData.forEach(row => {
                const columnsHtml = row.columns.map(column => {
                    // Get the column width class
                    const colClass = column.colClass.replace('md:', 'lg:'); // Use lg for wider view
                    
                    // Render all elements inside the column
                    const contentHtml = column.elements.map(renderPreviewElement).join('');
                    
                    // Return the wrapper HTML for the column
                    return `<div class="${colClass} px-3 mb-4 w-full space-y-3">${contentHtml}</div>`;
                }).join('');

                // Return the wrapper HTML for the row
                previewHtml += `
                    <div class="flex flex-wrap -mx-3">
                        ${columnsHtml}
                    </div>
                `;
            });

            return previewHtml;
        }

        // --- Initialization ---

        const start = () => {
            loadArticleContent();
            if (articleContent.length === 0) {
                addRowArticle(1);
                const firstRow = articleContent[0];
                if (firstRow) {
                    const firstCol = firstRow.columns[0];
                    addElementArticle(firstRow.id, firstCol.id, 'H1');
                    firstCol.elements[0].content = "Judul Artikel Baru";
                    addElementArticle(firstRow.id, firstCol.id, 'TEXT');
                    firstCol.elements[1].content =
                        "Sub Judul Artikel Baru";
                }
            }
            renderEditor();
            lucide.createIcons();
        };

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", start);
        } else {
            // DOM already loaded
            start();
        }

        // Expose global functions to window scope for HTML attributes
        // window.addRow = addRow;
        window.deleteRowArticle = deleteRowArticle;
        window.addElementArticle = addElementArticle;
        window.deleteElementArticle = deleteElementArticle;
        window.updateElementContentArticle = updateElementContentArticle;
        window.openModalForContentArticle = openModalForContentArticle;
        // window.saveModalContent = saveModalContent;
        // window.closeModal = closeModal;
        // window.handleSourceTypeChange = handleSourceTypeChange;
    }
</script>