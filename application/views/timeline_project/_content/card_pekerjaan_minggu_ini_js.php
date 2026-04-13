<script>
    // Define active colors for each section
    const sectionColors = {
        progress_section_1: '#B46BF2',
        progress_section_2: '#B46BF2',
        progress_section_3: '#B46BF2'
    };

    // Handle progress-tab click events
    $('.progress-tab').on('click', function () {
        $('.progress-tab').css('background-color', '#F3F2F2').removeClass('selected');
        $(this).css('background-color', sectionColors[this.id]).addClass('selected');
        const target = $(this).data('target');
        $('.custom-pane').hide(); // Hide all tab content
        $(target).show(); // Show the selected tab content
    });

    // Set initial state (optional, to ensure correct initial visibility)
    $('.custom-pane').hide(); // Hide all tab content
    $('#section_deadline').show(); // Show the first section by default


    function get_pekerjaan_minggu_ini(project,year) {
        $.ajax({
            type: "POST",
            url: base_url + 'get_pekerjaan_minggu_ini',
            data: {
                project:project,
                year:year
            },
            dataType: "json",
            success: function(response) {
                var deadline = ``;
                var undone = ``;
                var dimulai = ``;
                response.deadline.forEach((value) => {
                    deadline += `<div class="card mb-2" style="border-radius: 15px;">
                                <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="avatar avatar-30 coverimg rounded-circle" data-division="${value.kode_dep}" style="background-color: darkcyan; color: white; background-image: url(&quot;undefined&quot;);">
                                            ${value.kode_dep}
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <p class="fw-bold text-primary small mb-0">
                                            ${value.pekerjaan}
                                            </p>
                                            <p class="text-dark small mb-0" style="font-size:10px">
                                            ${value.sub_pekerjaan}
                                            </p>
                                            <p class="small text-secondary mb-0" style="font-size:10px">
                                            ${value.detail}
                                            </p>
                                        </div>
                                        <div class="col-5 text-end">
                                            <p class="fw-bold text-dark small mb-0">
                                                ${value.end}
                                            </p>
                                            <p class="text-secondary small mb-0" style="font-size:10px">
                                                ${value.pic}
                                            </p>
                                            <p class="small text-secondary mb-0">
                                                <span class="text-red">${value.deadline}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
                $('#row_deadline').empty().append(deadline);

                response.undone.forEach((value) => {
                    undone += `<div class="card mb-2" style="border-radius: 15px;">
                                <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="avatar avatar-30 coverimg rounded-circle" data-division="${value.kode_dep}" style="background-color: darkcyan; color: white; background-image: url(&quot;undefined&quot;);">
                                            ${value.kode_dep}
                                            </div>
                                        </div>
                                        <div class="col-5">
                                             <p class="fw-bold text-primary small mb-0">
                                            ${value.pekerjaan}
                                            </p>
                                            <p class="text-dark small mb-0" style="font-size:10px">
                                            ${value.sub_pekerjaan}
                                            </p>
                                            <p class="small text-secondary mb-0" style="font-size:10px">
                                            ${value.detail}
                                            </p>
                                        </div>
                                        <div class="col-5 text-end">
                                            <p class="fw-bold text-dark small mb-0">
                                                ${value.end}
                                            </p>
                                            <p class="text-secondary small mb-0" style="font-size:10px">
                                                ${value.pic}
                                            </p>
                                            <p class="small text-secondary mb-0">
                                                <span class="text-red">${value.deadline}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
                $('#row_undone').empty().append(undone);

                response.dimulai.forEach((value) => {
                    dimulai += `<div class="card mb-2" style="border-radius: 15px;">
                                <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="avatar avatar-30 coverimg rounded-circle" data-division="${value.kode_dep}" style="background-color: darkcyan; color: white; background-image: url(&quot;undefined&quot;);">
                                            ${value.kode_dep}
                                            </div>
                                        </div>
                                        <div class="col-5">
                                             <p class="fw-bold text-primary small mb-0">
                                            ${value.pekerjaan}
                                            </p>
                                            <p class="text-dark small mb-0" style="font-size:10px">
                                            ${value.sub_pekerjaan}
                                            </p>
                                            <p class="small text-secondary mb-0" style="font-size:10px">
                                            ${value.detail}
                                            </p>
                                        </div>
                                        <div class="col-5 text-end">
                                            <p class="fw-bold text-dark small mb-0">
                                                ${value.end}
                                            </p>
                                            <p class="text-secondary small mb-0" style="font-size:10px">
                                                ${value.pic}
                                            </p>
                                            <p class="small text-secondary mb-0">
                                                <span class="text-red">${value.deadline}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
                $('#row_dimulai').empty().append(dimulai);
            }
        });
    }
</script>