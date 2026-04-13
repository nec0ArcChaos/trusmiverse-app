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
    

    const ANSWER_OPTIONS = [
        { 
            text: 'Pasti Tidak', 
            value: -1.0 
        }, 
        { 
            text: 'Hampir Pasti Tidak', 
            value: -0.8 
        }, 
        { 
            text: 'Kemungkinan Besar Tidak', 
            value: -0.6 
        }, 
        { 
            text: 'Mungkin Tidak', 
            value: -0.4 
        }, 
        { 
            text: 'Tidak Tahu', 
            value: 0 
        }, 
        { 
            text: 'Mungkin', 
            value: 0.4 
        }, 
        { 
            text: 'Kemungkinan Besar', 
            value: 0.6 
        }, 
        { 
            text: 'Hampir Pasti', 
            value: 0.8 
        }, 
        { 
            text: 'Pasti', 
            value: 1.0 
        }
    ];

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

    // CF Calculation Functions
    function calculateCFHE(cfPakar, cfUser) {
        return cfPakar * cfUser;
    }

    function combineCF(cf1, cf2) {
        if(cf1 > 0 && cf2 > 0){
            cfCombined = cf1 + cf2 * (1 - cf1)
        } else if (cf1 < 0 && cf2 < 0) {
            cfCombined = cf1 + cf2 * (1 + cf1)
        } else {
            denom = (1 - Math.min(Math.abs(cf1), Math.abs(cf2)))
            denom = (denom == 0 ? 1 : denom) //menghindari divide by 0
            cfCombined = cf1 + cf2 / denom
        }
        return cfCombined;
    }

    function calculateCombinedCF(symptoms) {
        if (symptoms.length === 0) return 0;

        const cfResults = symptoms.map(s => calculateCFHE(s.cfPakar, s.cfUser));
        let cfCombined = cfResults[0];
        let cfCombinedList = [cfCombined];

        for (let i = 1; i < cfResults.length; i++) {
            cfCombined = combineCF(cfCombined, cfResults[i]);
            cfCombinedList.push(cfCombined)
        }

        return [cfCombined,cfCombinedList,cfResults];
    }

    function diagnose() {
        const diagnosisResults = [];

        for (const [diagnosisId, requiredSymptoms] of Object.entries(RULES)) {
            const ruleSymptoms = requiredSymptoms
                .map(symptomId => {
                    const symptomData = SYMPTOMS.find(s => s.id === symptomId);
                    const userAnswer = userAnswers[symptomId];

                    if (symptomData && userAnswer !== undefined) {
                        return {
                            gejalaid: symptomId,
                            cfPakar: symptomData.cfPakar,
                            cfUser: userAnswer
                        };
                    }
                    return null;
                })
                .filter(Boolean);
            cfCombinedResult = calculateCombinedCF(ruleSymptoms);
            const cfCombined = cfCombinedResult[0];
            const cfCombinedList = cfCombinedResult[1];
            const cfheList = cfCombinedResult[2];
            const percentage = Math.max(0, Math.min(100, cfCombined * 100));

            diagnosisResults.push({
                diagnosisId,
                diagnosisName: DIAGNOSES.find(d => d.id === diagnosisId)?.name || diagnosisId,
                cfCombined,
                percentage,
                ruleSymptoms,
                cfCombinedList,
                cfheList
            });
        }

        diagnosisResults.sort((a, b) => b.cfCombined - a.cfCombined);

        const bestDiagnosis = diagnosisResults[0];

        return {
            diagnosis: bestDiagnosis.diagnosisId,
            diagnosisName: bestDiagnosis.diagnosisName,
            percentage: bestDiagnosis.percentage,
            allResults: diagnosisResults,
            cfCombined: bestDiagnosis.cfCombined,
            timestamp: Date.now(),
            answers: userAnswers
        };
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
        document.getElementById('cf-combined').textContent = parseFloat(result.cfCombined).toFixed(4);


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

        // Create table
        historyList.innerHTML = '';
        const table = document.createElement('table');
        table.className = 'w-full';
        table.innerHTML = `
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
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