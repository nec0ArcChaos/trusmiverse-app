<!-- Script here -->
<script>
    function get_resume_data_all(project, year) {
        $.ajax({
            type: "POST",
            url: base_url + "get_resume_data_all",
            data: {
                year: year,
                project: project
            },
            dataType: "json",
            success: function(response) {
                // Mengupdate nilai teks
                $('#value_jumlah').text(response.data.jumlah);
                $('#value_ready').text(response.data.ready);
                $('#value_sisa').text(response.data.sisa);
                $('#value_ceklok').text(response.data.ceklok);
                $('#value_sp3k').text(response.data.sp3k);
                $('#value_bank').text(response.data.bank);

                $('#booking_persen').text(response.header.booking_persen + '%');
                $('#akad_persen').text(response.header.akad_persen + '%');
                $('#booking_persen')
                    .removeClass(function(index, className) {
                        return (className.match(/(^|\s)text-\S+/g) || []).join(' '); // Menghapus semua class diawali "text-"
                    })
                    .addClass('text-' + response.header.booking_warna);

                $('#akad_persen')
                    .removeClass(function(index, className) {
                        return (className.match(/(^|\s)text-\S+/g) || []).join(' '); // Menghapus semua class diawali "text-"
                    })
                    .addClass('text-' + response.header.akad_warna);

                $('#booking_jumlah').text(response.header.booking_actual + '/' + response.header.booking_target);
                $('#akad_jumlah').text(response.header.akad_actual + '/' + response.header.akad_target);
                $('#booking_progres').css('width', response.header.booking_persen + '%');
                $('#akad_progres').css('width', response.header.akad_persen + '%');
                $('#booking_progres')
                    .removeClass(function(index, className) {
                        return (className.match(/(^|\s)bg-soft-\S+/g) || []).join(' '); // Menghapus semua class diawali "bg-soft-"
                    })
                    .addClass('progress-bar bg-soft-' + response.header.booking_warna);

                $('#akad_progres')
                    .removeClass(function(index, className) {
                        return (className.match(/(^|\s)bg-soft-\S+/g) || []).join(' '); // Menghapus semua class diawali "bg-soft-"
                    })
                    .addClass('progress-bar bg-soft-' + response.header.akad_warna);

            }
        });
    }
</script>