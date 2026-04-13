<!-- Script here -->
 <script>
    function get_resume_activity(project,year){
        $.ajax({
            type: "POST",
            url: base_url + '/get_resume_activity',
            data: {
                project:project,
                year:year
            },
            dataType: "json",
            success: function (response) {
                if(response != null){

                    $('#d_ibr_jln_berhasil').text(response.ibr_jln_berhasil+' ('+response.persen_jln_berhasil+'%)');
                    $('#d_ibr_tdk_berhasil').text(response.ibr_tdk_berhasil+' ('+response.persen_tdk_berhasil+'%)');
                    $('#d_ibr_tdk_jalan').text(response.ibr_tdk_jalan+' ('+response.persen_tdk_jalan+'%)');
                    $('#d_ibr_progres').text(response.ibr_progres+' ('+response.persen_progres+'%)');
                    $('#d_ibr_belum').text(response.ibr_belum+' ('+response.persen_belum+'%)');
                    $('#t_ibr').text(response.ibr_jumlah);
                    $('#t_mom').text(response.mom_jumlah);
                    $('#t_comp').text(response.comp_jumlah);
                    $('#t_tt').text(response.tt_jumlah);
                    $('#t_gen').text(response.gen_jumlah);
                    $('#t_coac').text(response.coac_jumlah);
                }
            }
        });
    }
 </script>