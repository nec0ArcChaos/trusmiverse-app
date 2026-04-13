<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dropzone5-9-3/dropzone.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/paging.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/slimselect/slimselect.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<!-- script state awal -->
<script>

    $(document).ready(function() {

    });
</script>
<!-- /script state awal -->

<script>
    // function timer(countDownDate) {
    //     var countDownDate = new Date(countDownDate).getTime();

    //     // Update the count down every 1 second
    //     var x = setInterval(function() {

    //         // Get today's date and time
    //         var now = new Date().getTime();

    //         // Find the distance between now and the count down date
    //         var distance = countDownDate - now;

    //         // Time calculations for days, hours, minutes and seconds
    //         var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    //         var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    //         var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    //         var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    //         // Display the result in the element with id="demo"
    //         document.getElementById("days").innerHTML = days;
    //         document.getElementById("hrs").innerHTML = hours
    //         document.getElementById("min").innerHTML = minutes
    //         document.getElementById("sec").innerHTML = seconds

    //         // If the count down is finished, write some text
    //         if (distance < 0) {
    //             clearInterval(x);
    //             document.getElementById("timer").innerHTML = "Your Plan MoM is Overdue.";
    //         }
    //     }, 1000);
    // }
</script>

<!-- Detail Task Start -->
<script>

    function submit_answer() 
    {
        total   = parseInt($(`input[name="total_pertanyaan"]`).val());
        for (let i = 1; i <= total; i++) {   
            type_id = parseInt($(`#type_id_${i}`).val());
            // console.log(i,type_id);
            if (type_id == 1) {
                jwb = $(`#answer_${i}`).val();
            } else {
                jwb = $(`input[name="answer_${i}"]:checked`).length;
            }
            // console.log(i,jwb);
            nomor   = $(`#no_urut_${i}`).val();
            huruf   = $(`#huruf_urut_${i}`).val();
            if ((jwb < 1 || jwb == "") && nomor != 0) {
                $.confirm({
                    icon: 'fa fa-close',
                    title: 'Oops!',
                    theme: 'material',
                    type: 'red',
                    content: `Oops, pertanyaan ${huruf}.${nomor} belum terjawab !!`,
                    buttons: {
                        close: {
                            actions: function() {}
                        },
                    },
                });                
                return false;
            } else if (i == total) {
                $.confirm({
                    icon: 'fa fa-spinner fa-spin',
                    title: 'Please Wait!',
                    theme: 'material',
                    type: 'blue',
                    content: 'Loading...',
                    buttons: {
                        close: {
                            isHidden: true,
                            actions: function() {}
                        },
                    },
                    onOpen: function() {
                        $.ajax({
                            url: `<?= base_url() ?>qna/qna_form/submit_answer`,
                            type: 'POST',
                            dataType: 'JSON',
                            data: $("#form_answer_qna").serialize(),
                            beforeSend: function() {
                                $("#btn_submit_answer").attr("disabled","disabled");
                            },
                            success: function(res){
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Success!',
                                    buttons: {
                                        close: function() {
                                            // location.reload();
                                            window.location.href = '<?= base_url(); ?>frm-close/'+$("#encrypt_id").val();
                                        }
                                    },
                                });
                                // console.log(res);
                                $("#btn_submit_answer").removeAttr("disabled");
                            },
                            error: function(xhr){
                                jconfirm.instances[0].close();
                                console.log(xhr.responseText);
                            },
                            complete: function(){},
                        });
                    },
                });
            }
        }
    }
</script>
<!-- /Detail Task Start -->