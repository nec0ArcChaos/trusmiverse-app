<style>
    .code {
        background-color: #1f1f1f;
        padding-bottom: 0px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
        border-radius: 10px;
        width: 100%;
        color: #68cdfe;
    }
</style>

<script>
    $(document).ready(function(){
        $('#prompt').val('');
        $('#prompt').focus();        
    });

    // $(document).on('keypress', function(e){
    //     if(e.which == 13) {
    //         tanya_dong();
    //     }
    // })

    function tanya_dong(){
        prompt = $('#prompt').val();
        if(prompt.length < 4){
            alert('Tidak dapat menanyakan pertanyaan tersebut!');
            $('#prompt').focus();
        }else{

            
            $.ajax({
                url: "http://192.168.23.78:7547/chat",
                type: "POST",
                dataType: "json",
                headers: {
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(
                    {
                        prompt: prompt,
                    }
                ),
                beforeSend: function(){

                    // add spinner loader with fa icon to id query_btn
                    $('#query_btn').html('<div class="loader"><i class="fas fa-stop text-secondary"></i></div>');

                    // remove attribute onclick on id query_btn to prevent onclick function
                    $('#query_btn').removeAttr('onclick');

                    // style cursor default
                    $('#query_btn').css('cursor', 'default');

                    loader = `<div class="row">
                                <div class="col">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <table>
                                                        <tr>
                                                            <td style="white-space: normal; vertical-align: top; padding-right: 20px">
                                                                <div class="task-contain">
                                                                    <figure class="avatar avatar-40 rounded-circle coverimg vm">
                                                                        <img src="https://trusmiverse.com/hr/uploads/profile/profile_1698469559.png" alt="">
                                                                    </figure>
                                                                </div>
                                                            </td>
                                                            <td class="pl-3" style="white-space:normal !important;">
                                                                <p>
                                                                    <i class="fas fa-spinner fa-spin"></i>		
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>`;
                    $('#answer').empty().append(loader);
                },
                successs: function(response){
                    // console.info(response.data);
                    // $('#answer').html(response.data);
                },
                error: function(err){
                    console.info(err);
                    alert('Mohon maaf terjadi kesalahan');
                    $('#answer').empty();

                    // enable click on id query_btn
                    $('#query_btn').attr('onclick', 'tanya_dong()');

                    // remove spinner loader from id query_btn
                    $('#query_btn').html('<i class="bi bi-search"></i>');

                    // style cursor pointer
                    $('#query_btn').css('cursor', 'pointer');
                },
                complete: function(response){

                    if(response.status == 200){

                        ai_answer = JSON.parse(response.responseText).answer;
                        tema = JSON.parse(response.responseText).tema;

                        // Mengubah tulisan tebal
                        ai_answer = ai_answer.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');

                        // Mengubah \n\n menjadi <br><br>
                        ai_answer = ai_answer.replace(/\n\n/g, '<br><br>');

                        // Mengubah \n menjadi <br>
                        ai_answer = ai_answer.replace(/\\n/g, '<br>');

                        // Mengubah kode blok
                        ai_answer = ai_answer.replace(/```(html|sql|php|javascript)([\s\S]*?)```/g, function(match, language, code) {
                            // Escape karakter khusus di dalam blok kode
                            let escapedCode = code.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                            return `<pre><code class="code">${escapedCode}</code></pre>`;
                        });

                        // Escape karakter khusus HTML di luar blok kode
                        ai_answer = escapeHtmlOutsideCodeBlocks(ai_answer);


                        answer = `<div class="row">
                                <div class="col">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <table>
                                                        <tr>
                                                            <td style="white-space: normal; vertical-align: top; padding-right: 20px">
                                                                <div class="task-contain">
                                                                    <figure class="avatar avatar-40 rounded-circle coverimg vm">
                                                                        <img src="https://trusmiverse.com/hr/uploads/profile/profile_1698469559.png" alt="">
                                                                    </figure>
                                                                </div>
                                                            </td>
                                                            <td class="pl-3" style="white-space:normal !important;">
                                                                <p>
                                                                    ${ai_answer}					
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>`;

                        $('#answer').empty();
                        $('#answer').append(answer);

                        // get_tema_pertanyaa(prompt, answer);

                        save_chat(tema, prompt, ai_answer);

                        
                    }else{

                        // mohon maaf terjadi kesalahan
                        // alert('Mohon maaf terjadi kesalahan');
                        $('#answer').empty();


                    }


                    // enable click on id query_btn
                    $('#query_btn').attr('onclick', 'tanya_dong()');

                    // remove spinner loader from id query_btn
                    $('#query_btn').html('<i class="bi bi-search"></i>');

                    // style cursor pointer
                    $('#query_btn').css('cursor', 'pointer');

                },
            })
        }
        
    }

    // Fungsi untuk escape karakter khusus HTML di luar blok kode
    function escapeHtmlOutsideCodeBlocks(text) {
        // Escape karakter khusus HTML
        return text.replace(/<(?!\/?(code|pre|b|br)\b)[^<>\n]+?>/gi, function(match) {
            return match.replace(/</g, '&lt;').replace(/>/g, '&gt;');
        });
    }


    function get_tema_pertanyaa(prompt, answer){
        $.ajax({
            url: "http://192.168.23.78:7547/tema",
            type: "POST",
            dataType: "json",
            headers: {
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(
                {
                    prompt: prompt,
                    answer: answer
                }
            ),
            success: function(response){
                console.info(response.tema);
            },
            error: function(err){
                console.error(`Error: ${err}`)
            },
        })
    }


    function save_chat(tema, prompt, answer){
        $.ajax({
            url: "<?= base_url('trusmi_ai_chat/save_chat') ?>",
            type: "POST",
            dataType: "json",
            data: {
                tema: tema,
                prompt: prompt,
                answer: answer,
            },
            success: function(response){
                console.info(response);
            },
            error: function(err){
                console.error(`Error: ${err}`);
            },
        })
    }

</script>