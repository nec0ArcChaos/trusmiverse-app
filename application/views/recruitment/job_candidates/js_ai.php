<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    $(document).ready(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        // alert(maxDate);
        $('#tgl_masuk').attr('min', maxDate);

        $(document).on('keyup', '.key_list', function(e) {
            if (e.which == 13) { // Kode 13 adalah key code untuk tombol enter
                e.preventDefault(); // Mencegah form dari submit default
                tambah_list(); // Memanggil fungsi tambah_list
            }
        });

        // Datepicker
        var start = moment().startOf('week');
        var end = moment().endOf('week');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
            get_candidates(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }

        $('.range').daterangepicker({
            startDate: start,
            endDate: end,
            "drops": "down",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            }
        }, cb);

        cb(start, end);
        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_candidates(start, end);

        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_candidates(start, end);
        })
        // Job Desc Text_Area
        $('#job_desc').summernote({
            placeholder: 'Job Description',
            tabsize: 2,
            height: 217,
            width: 440,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
    });

    function get_candidates(start, end) {
        jc_job_id = $('#jc_job_id').val();
        $('#dt_jc').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'List Job Candidates',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>recruitment/job_candidates/get_candidates",
                "data": {
                    start: start,
                    end: end,
                    id: jc_job_id
                }
            },
            "columns": [{
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        download = `<a onclick="open_resume('` + row['job_resume'] + `','` + row['full_name'] + `')"><button type = "button" class = "btn btn-primary btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-download" ></i></button > </a>`;
                        edit = `<a onclick="show_edit_modal(` + data + `,` + row['application_status'] + `)"><button type = "button" class = "btn btn-success btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-pencil-square" style = "color:white;"></i></button > </a>`;
                        assign_test = `<button type="button" 
                                class="btn btn-info btn-sm waves-effect waves-light assign-test-btn" data-id="${data}" data-id_user="${row.id_user_talent}" data-email="${row.email}" data-access="${row.access}">
                            <i class="bi bi-file-earmark-person text-white"></i>
                        </button>`;
                        delete_xja = `<a onclick="delete_jc(` + data + `)"><button type = "button" class = "btn btn-danger btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-trash3" style = "color:white;" ></i></button > </a>`;
                        if (row['application_status'] == 0 || row['application_status'] == 1 || row['application_status'] == 2 || row['application_status'] == 10) {
                            action = `${download} ${edit} ${assign_test} ${delete_xja}`;
                        } else {
                            action = `${download} ${delete_xja}`;
                        }
                        return action;
                    }
                },
                {
                    'data': 'application_status',
                    'render': function(data, type, row) {
                        status = '';
                        if (data == 0) {
                            $status = '<span class="badge bg-yellow">Waiting</span>';
                        } else if (data == 1) {
                            $status = '<span class="badge bg-primary">Psikotes</span>';
                        } else if (data == 2) {
                            $status = '<span class="badge bg-danger">Lamaran Ditolak</span>';
                        } else if (data == 3) {
                            $status = '<span class="badge" style="background-color: #00BCD4;">Interview User</span>';
                        } else if (data == 4) {
                            $status = '<span class="badge" style="background-color: #FF5722;">Gagal Psikotes</span>';
                        } else if (data == 5) {
                            $status = '<span class="badge" style="background-color: #795548;">Administrasi</span>';
                        } else if (data == 6) {
                            $status = '<span class="badge" style="background-color: #4CAF50;">Gagal Interview</span>';
                        } else if (data == 7) {
                            $status = '<span class="badge" style="background-color: #7986CB;">Lengkap / Diterima</span>';
                        } else if (data == 8) {
                            $status = '<span class="badge" style="background-color: #E91E63;">Tidak Lengkap / Ditolak</span>';
                        } else if (data == 10) {
                            $status = '<span class="badge" style="background-color: #0086A2;">Interview HR</span>';
                        }
                        return $status
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        download = `<a onclick="cover_letter('` + data + `')"><button type = "button" class = "btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-envelope-at-fill" ></i></button > </a>`;
                        return download;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'status_score',
                    'render': function(data, type, row) {
                        status = '';
                        if (data == 'Not Recomended') {
                            status = '<span class="badge bg-danger">' + data + '</span>';
                        } else if (data == 'Considered') {
                            status = '<span class="badge bg-yellow">' + data + '</span>';
                        } else if (data == 'Recomended') {
                            status = '<span class="badge bg-success">' + data + '</span>';
                        } else {
                            status = '<span class="badge bg-danger">' + data + '</span>';
                        }
                        if (data != '') {
                            return status;
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'matching_total_score',
                    'render': function(data, type, row) {
                        if (data != '') {
                            if (row['matching_total_score'] < 70) {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            } else if (row['matching_total_score'] < 80 && row['matching_total_score'] >= 70) {
                                status = '<span class="badge bg-yellow">' + data + '%</span>';
                            } else if (row['matching_total_score'] >= 80) {
                                status = '<span class="badge bg-success">' + data + '%</span>';
                            } else {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            }
                            if (data != '') {
                                return status;
                            } else {
                                return ``;
                            }
                        } else {
                            return '';
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'matching_score_profile',
                    'render': function(data, type, row) {
                        if (data != '') {
                            if (row['matching_score_profile'] < 70) {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            } else if (row['matching_score_profile'] < 80 && row['matching_score_profile'] >= 70) {
                                status = '<span class="badge bg-yellow">' + data + '%</span>';
                            } else if (row['matching_score_profile'] >= 80) {
                                status = '<span class="badge bg-success">' + data + '%</span>';
                            } else {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            }
                            if (data != '') {
                                return status;
                            } else {
                                return ``;
                            }
                        } else {
                            return '';
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'matching_score_skills',
                    'render': function(data, type, row) {
                        if (data != '') {
                            if (row['matching_score_skills'] < 70) {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            } else if (row['matching_score_skills'] < 80 && row['matching_score_skills'] >= 70) {
                                status = '<span class="badge bg-yellow">' + data + '%</span>';
                            } else if (row['matching_score_skills'] >= 80) {
                                status = '<span class="badge bg-success">' + data + '%</span>';
                            } else {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            }
                            if (data != '') {
                                return status;
                            } else {
                                return ``;
                            }
                        } else {
                            return '';
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'simulation_score',
                    'render': function(data, type, row) {
                        if (data != '') {
                            if (row['matching_score_skills'] < 70) {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            } else if (row['matching_score_skills'] < 80 && row['matching_score_skills'] >= 70) {
                                status = '<span class="badge bg-yellow">' + data + '%</span>';
                            } else if (row['matching_score_skills'] >= 80) {
                                status = '<span class="badge bg-success">' + data + '%</span>';
                            } else {
                                status = '<span class="badge bg-danger">' + data + '%</span>';
                            }
                            if (data != '') {
                                return status;
                            } else {
                                return ``;
                            }
                        } else {
                            return '';
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'simulation_grade',
                },
                {
                    'data': 'company_name',
                },
                {
                    'data': 'category_name',
                },
                {
                    'data': 'job_title',
                },
                {
                    'data': 'role_name',
                },
                {
                    'data': 'full_name',

                },
                {
                    'data': 'gender',
                },
                {
                    'data': 'contact',
                },
                {
                    'data': 'email',
                },
                {
                    'data': 'age',
                },
                {
                    'data': 'domisili',
                },
                {
                    'data': 'pendidikan',
                },
                {
                    'data': 'jurusan',
                },
                {
                    'data': 'tempat_pendidikan',
                },
                {
                    'data': 'posisi_kerja_terakhir',
                },
                {
                    'data': 'tempat_kerja_terakhir',
                },
                {
                    'data': 'masa_kerja_terakhir',
                },
                {
                    'data': 'salary',
                },
                {
                    'data': 'informasi',
                },
                {
                    'data': 'question',
                },
                {
                    'data': 'tiu_score',
                },
                {
                    'data': 'mask_type',
                    'render': function(data, type, row) {
                        if (row.mask_type == '') {
                            return ``;
                        }
                        return ` Most : ${row.mask_type} | Least : ${row.life_type} | Change : ${row.change_type} `;
                    }
                },
                {
                    'data': 'm_d',
                },
                {
                    'data': 'm_i',
                },
                {
                    'data': 'm_s',
                },
                {
                    'data': 'm_c',
                },
                {
                    'data': 'l_d',
                },
                {
                    'data': 'l_i',
                },
                {
                    'data': 'l_s',
                },
                {
                    'data': 'l_c',
                },
                {
                    'data': 'c_d',
                },
                {
                    'data': 'c_i',
                },
                {
                    'data': 'c_s',
                },
                {
                    'data': 'c_c',
                },
                {
                    'data': 'E_percent',
                    render: function(data, type, row) {
                        if (data == null || data == "" || data == 0) {
                            return ``;
                        }
                        if (row.E_percent == null || row.I_percent == null || row.S_percent == null || row.N_percent == null || row.T_percent == null || row.F_percent == null || row.P_percent == null || row.J_percent == null) {
                            return 'N/A'; // Tampilkan N/A jika data tes tidak lengkap
                        }
                        const firstLetter = (row.I_percent >= row.E_percent) ? 'I' : 'E';
                        const secondLetter = (row.N_percent >= row.S_percent) ? 'N' : 'S';
                        const thirdLetter = (row.T_percent >= row.F_percent) ? 'T' : 'F';
                        const fourthLetter = (row.P_percent >= row.J_percent) ? 'P' : 'J';

                        // 3. Gabungkan huruf-huruf tersebut dan kembalikan hasilnya
                        const mbtiType = `${firstLetter}${secondLetter}${thirdLetter}${fourthLetter}`;

                        // Anda bisa menambahkan styling di sini jika perlu
                        return `<span class="badge bg-primary">${mbtiType}</span>`;
                    }
                },
                {
                    data: 'E_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'I_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'S_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'N_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'T_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'F_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'P_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'J_percent',
                    render: function(data, type, row) {
                        return (data == null || data == 0 || data == "") ? '' : data + ' %';
                    }
                },
                {
                    data: 'score_cfit'
                },
                {
                    'data': 'created_at',
                }
            ],
        });
    }

    function detail_screener(id) {
        $.ajax({
            url: "<?= base_url('recruitment/job_candidates/detail_screener') ?>",
            method: "POST",
            data: {
                application_id: id
            },
            dataType: "JSON",
            success: function(res) {
                // console.log(res);

                if (res.candidate['photo'] != null && res.candidate['photo'] != '') {
                    // $('#candidate_avatar').empty().html('<img src="https://karir-dev.trusmigroup.com/storage/foto_profile/user_15.png" class="img-fluid rounded-circle" alt="Candidate Photo" style="width: 150px; height: 150px;">');
                    $('#candidate_avatar').empty().html('<img src="https://karir-dev.trusmigroup.com/storage/' + res.candidate['photo'] + '" class="img-fluid rounded-circle" alt="Candidate Photo" style="width: 150px; height: 150px;">');
                } else {
                    // $('#candidate_avatar').empty().html('<img src="https://karir-dev.trusmigroup.com/storage/foto_profile/user_15.png" class="img-fluid rounded-circle" alt="Candidate Photo" style="width: 150px; height: 150px;">');
                    $('#candidate_avatar').empty().html('<i class="fas fa-user-circle fa-5x text-muted"></i>');
                }
                $('#candidate_name').text(res.candidate['full_name']);
                $('#candidate_id').text('ID : ' + res.candidate['application_id']);
                $('#candidate_position').text('Posisi : ' + res.candidate['role_name']);
                $('#candidate_date').text('Screening At : ' + res.candidate['processed_at']);
                $('#candidate_reason').empty().html('<strong>AI Reasoning</strong> : ' + res.candidate['reason']);
                if (parseInt(res.candidate['matching_total_score']) < 70) {
                    $('#div_candidate_score').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-danger');
                    $('#candidate_score').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-danger');
                } else if (parseInt(res.candidate['matching_total_score']) < 80 && parseInt(res.candidate['matching_total_score']) >= 70) {
                    $('#div_candidate_score').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-warning');
                    $('#candidate_score').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-warning');
                } else {
                    $('#div_candidate_score').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-success');
                    $('#candidate_score').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-success');
                }
                $('#candidate_score').text(parseInt(res.candidate['matching_total_score']) + '%');
                if (parseInt(res.candidate['matching_score_skills']) < 70) {
                    $('#div_candidate_skill').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-danger');
                    $('#candidate_skill').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-danger');
                } else if (parseInt(res.candidate['matching_score_skills']) < 80 && parseInt(res.candidate['matching_score_skills']) >= 70) {
                    $('#div_candidate_skill').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-warning');
                    $('#candidate_skill').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-warning');
                } else {
                    $('#div_candidate_skill').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-success');
                    $('#candidate_skill').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-success');
                }
                $('#candidate_skill').text(parseInt(res.candidate['matching_score_skills']) + '%');
                if (parseInt(res.candidate['matching_score_profile']) < 70) {
                    $('#div_candidate_profile').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-danger');
                    $('#candidate_profile').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-danger');
                } else if (parseInt(res.candidate['matching_score_profile']) < 80 && parseInt(res.candidate['matching_score_profile']) >= 70) {
                    $('#div_candidate_profile').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-warning');
                    $('#candidate_profile').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-warning');
                } else {
                    $('#div_candidate_profile').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-success');
                    $('#candidate_profile').removeClass('bg-success bg-warning bg-danger bg-info').addClass('bg-success');
                }
                $('#candidate_profile').html(parseInt(res.candidate['matching_score_profile']) + '%');
                // $("#detailModalScreener").modal('show');

                // Populate matched profile
                $('#matchedProfileItems').empty();
                if (res.matched_profile.length > 0) {
                    res.matched_profile.forEach(function(item) {
                        $('#matchedProfileItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2"><i class="fas fa-check-circle text-success me-2"></i>' + item.description + '</li>');
                    });
                } else {
                    $('#matchedProfileItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2">Tidak ada data</li>');
                }
                // Populate missing profile
                $('#missingProfileItems').empty();
                if (res.missing_profile.length > 0) {
                    res.missing_profile.forEach(function(item) {
                        $('#missingProfileItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2"><i class="fas fa-times-circle text-danger me-2"></i>' + item.description + '</li>');
                    });
                } else {
                    $('#missingProfileItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2">Tidak ada data</li>');
                }
                // Populate matched skills
                $('#matchedSkillsItems').empty();
                if (res.matched_skills.length > 0) {
                    res.matched_skills.forEach(function(item) {
                        $('#matchedSkillsItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2"><i class="fas fa-check-circle text-success me-2"></i>' + item.description + '</li>');
                    });
                } else {
                    $('#matchedSkillsItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2">Tidak ada data</li>');
                }
                // Populate missing skills
                $('#missingSkillsItems').empty();
                if (res.missing_skills.length > 0) {
                    res.missing_skills.forEach(function(item) {
                        $('#missingSkillsItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2"><i class="fas fa-times-circle text-danger me-2"></i>' + item.description + '</li>');
                    });
                } else {
                    $('#missingSkillsItems').append('<li class="list-group-item d-flex align-items-center border-0 py-2">Tidak ada data</li>');
                }
                // Populate score table details
                $('#scoringDetails').empty();
                if (res.score_detail.length > 0) {
                    res.score_detail.forEach(function(item) {
                        let custom_bg = item.score < 70 ? 'bg-danger text-danger' : item.score < 80 ? 'bg-warning text-warning' : 'bg-success text-success';
                        $('#scoringDetails').append(
                            `<tr>
                                <td class="ps-4">` + item.category + `</td>
                                <td class="ps-4">` + item.criteria + `</td>
                                <td class="text-center" style="min-width:100px;">` + item.weight + `</td>
                                <td class="text-center" style="min-width:100px;">` + item.score + `</td>
                                <td class="pe-4 text-center" style="min-width:100px;">
                                    <span class="badge ${custom_bg} bg-opacity-10 px-2 py-1">` +
                            item.score + `%</span>
                                </td>
                                <td class="text-start" style-"text-align: justify;">` + item.reason + `</td>
                            </tr>`
                        );
                    });
                } else {
                    $('#scoringDetails').append('<tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>');
                }

                console.log(res.radar);
                avgRadarSimulationScore(res.radar);
                console.log(res.radar_cv);
                avgRadarCvScore(res.radar_cv);

                // $('#detailModalScreener .modal-body').html(res.html);
                // $('#detailModalScreener').modal('show');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    let chart_simulation_score;

    function avgRadarSimulationScore(datasets) {

        let categories_chart_simulation_score = [
            "Communication",
            "Expertise",
            "Support",
            "Persuasion",
            "Interaction",
            "Diligence",
            "Satisfaction",
            "Conversion"
        ];

        if (datasets.length > 0) {
            categories_chart_simulation_score = datasets.map(item => item.statement_list);
            value_chart_simulation_score = datasets.map(item => item.score);
            console.log(value_chart_simulation_score);
        } else {
            value_chart_simulation_score = [
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0
            ];
        }

        if (chart_simulation_score != null) {
            chart_simulation_score.updateOptions({
                series: [{
                    data: value_chart_simulation_score
                }],
                labels: categories_chart_simulation_score,
                xaxis: {
                    categories: categories_chart_simulation_score
                }
            });
            return;
        }

        // Contoh data (skala 0 - 100). Bisa ditukar/dinamiskan.
        const series_chart_simulation_score = [{
            name: "Simulation Score",
            data: value_chart_simulation_score
        }];

        const options_chart_simulation_score = {
            chart: {
                height: 520,
                type: 'radar',
                title: {
                    text: 'Simulation Score', // Add your desired title here
                    floating: true, // Optional: makes the title float on top
                    style: {
                        fontSize: '16px' // Optional: sets the font size
                    }
                },
                toolbar: {
                    show: false
                },
                parentHeightOffset: 0,
                animations: {
                    enabled: true
                }
            },
            series: series_chart_simulation_score,
            labels: categories_chart_simulation_score,
            xaxis: {
                categories: categories_chart_simulation_score
            },
            yaxis: {
                show: true,
                min: 0,
                max: 100,
                tickAmount: 5
            },
            plotOptions: {
                radar: {
                    size: 140,
                    polygons: {
                        strokeColors: '#e6edf3',
                        fill: {
                            colors: ['#fff', '#f8fbff']
                        },
                        connectorColors: '#dbe7f5'
                    }
                }
            },
            markers: {
                size: 4
            },
            stroke: {
                width: 2
            },
            fill: {
                opacity: 0.25
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " / 100";
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            },
            responsive: [{
                breakpoint: 640,
                options: {
                    chart: {
                        height: 420
                    },
                    plotOptions: {
                        radar: {
                            size: 110
                        }
                    }
                }
            }]
        };

        chart_simulation_score = new ApexCharts(document.querySelector("#chart_simulation_score"), options_chart_simulation_score);

        chart_simulation_score.render();
    }

    let chart_cv_score;

    function avgRadarCvScore(datasets_cv) {

        let categories_chart_cv_score = [
            "Usia",
            "status",
            "Gender",
            "Pendidikan",
            "Pengalaman",
            "Soft Skills",
            "Keahlian",
            "Job Desc",
            "Sertifikasi",
            "Portofolio"
        ];

        if (datasets_cv.length > 0) {
            categories_chart_cv_score = datasets_cv.map(item => item.criteria);
            value_chart_cv_score = datasets_cv.map(item => item.score);
            console.log(value_chart_cv_score);
        } else {
            value_chart_cv_score = [
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0
            ];
        }

        if (chart_cv_score != null) {
            chart_cv_score.updateOptions({
                series: [{
                    data: value_chart_cv_score
                }],
                labels: categories_chart_cv_score,
                xaxis: {
                    categories: categories_chart_cv_score
                }
            });
            return;
        }

        // Contoh data (skala 0 - 100). Bisa ditukar/dinamiskan.
        const series_chart_cv_score = [{
            name: "CV Score",
            data: value_chart_cv_score
        }];

        const options_chart_cv_score = {
            chart: {
                height: 520,
                type: 'radar',
                title: {
                    text: 'CV Score', // Add your desired title here
                    floating: true, // Optional: makes the title float on top
                    style: {
                        fontSize: '16px' // Optional: sets the font size
                    }
                },
                toolbar: {
                    show: false
                },
                parentHeightOffset: 0,
                animations: {
                    enabled: true
                }
            },
            series: series_chart_cv_score,
            labels: categories_chart_cv_score,
            xaxis: {
                categories: categories_chart_cv_score
            },
            yaxis: {
                show: true,
                min: 0,
                max: 100,
                tickAmount: 5
            },
            plotOptions: {
                radar: {
                    size: 140,
                    polygons: {
                        strokeColors: '#e6edf3',
                        fill: {
                            colors: ['#fff', '#f8fbff']
                        },
                        connectorColors: '#dbe7f5'
                    }
                }
            },
            markers: {
                size: 4
            },
            stroke: {
                width: 2
            },
            fill: {
                opacity: 0.25
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " / 100";
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            },
            responsive: [{
                breakpoint: 640,
                options: {
                    chart: {
                        height: 420
                    },
                    plotOptions: {
                        radar: {
                            size: 110
                        }
                    }
                }
            }]
        };
        chart_cv_score = new ApexCharts(document.querySelector("#chart_cv_score"), options_chart_cv_score);
        chart_cv_score.render();
    }

    function cover_letter(id) {
        $.ajax({
            url: "<?= base_url('recruitment/job_candidates/cover_letter') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                $('#cover_leter_title').text('Cover Letter For ' + res.cover_letter['job_title']);
                $('#modal_cover_letter .modal-body').html(res.cover_letter['message']);
                $('#modal_cover_letter').modal('show');
            }
        })
    }

    function open_resume(url, name) {
        // console.log(url);
        window.open(url, '_blank');
        // $.confirm({
        //     icon: 'fa fa-spinner fa-spin',
        //     title: 'Please Wait!',
        //     theme: 'material',
        //     type: 'blue',
        //     content: 'Refresh the  page or download the CV, if there is a problem to view the CV',
        //     buttons: {
        //         close: {
        //             isHidden: true,
        //             actions: function() {}
        //         },
        //     },
        //     onOpen: function() {
        //         setTimeout(function() {
        //             // var randomString = Math.random().toString(36).substring(2, 15);
        //             // var proxyUrl = 'https://docs.google.com/viewer?url=' + encodeURIComponent(url) + '&embedded=true&rand=' + randomString;
        //             // window.open(proxyUrl);
        //             // var downloadLink = document.createElement('a');
        //             // downloadLink.href = url;
        //             // downloadLink.download = `CV_` + name + `.pdf`; // Optional: specify a filename if desired
        //             // document.body.appendChild(downloadLink);
        //             // downloadLink.click();
        //             // document.body.removeChild(downloadLink);
        //             // jconfirm.instances[0].close();
        //         }, 2000);
        //     }
        // });
    }

    function show_edit_modal(id, app_status) {
        detail_screener(id);
        $('#btn_save_status').removeAttr('disabled');
        let status = '';
        status = `<option value = "0">Waiting</option><option value = "10">Interview HR</option><option value = "2">Tolak Lamaran</option>`;
        $('#select_status').html(status);
        $('#select_status').val(app_status);
        select_status.update();
        $('#job_id').val(id);
        $('#alasan').hide();
        $('#interview_hr_fields').remove();
        updateKeterangan();
        $('#modal_edit_status').modal('show');
    }

    function updateKeterangan() {
        $("#alasan").hide();
        $("#interview_hr_fields").hide();

        var val = $("#select_status").val();

        if (val == 2 && <?= $_SESSION['user_id'] ?> == 1) {
            $("#alasan").show();
        }

        if (val == 10) {
            showInterviewHR();
        }
    }

    function showInterviewHR() {
        if (document.getElementById('interview_hr_fields') === null) {
            var alasanEl = document.getElementById('alasan');
            if (!alasanEl) return;
            var parentRow = alasanEl.closest('.row');
            var div = document.createElement('div');
            div.id = 'interview_hr_fields';
            div.style.display = 'none';
            div.innerHTML =
                '<hr class="my-2">' +
                '<div class="row">' +
                    // '<div class="col-6">' +
                    //     '<label class="form-label required small">Pilih Tanggal</label>' +
                    //     '<div id="date_slots" class="d-flex flex-wrap gap-2 mt-1"></div>' +
                    //     '<input type="hidden" id="date_interview_hr">' +
                    // '</div>' +
                    '<div class="col-6">' +
                        '<label class="form-label required small">Pilih Tanggal</label>' +
                        '<input type="date" id="date_interview_hr" class="form-control">' +
                    '</div>' +
                    '<div class="col-6">' +
                        '<label class="form-label required small">Jam Yang Tersedia</label>' +
                        '<div id="time_slots" class="d-flex flex-wrap gap-2 mt-1">' +
                            '<button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="10:00">10:00</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="10:30">10:30</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="11:00">11:00</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="11:30">11:30</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="13:00">13:00</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="13:30">13:30</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="14:00">14:00</button>' +
                        '</div>' +
                        '<input type="hidden" id="time_interview_hr">' +
                    '</div>' +
                '</div>' +
                '<div class="row mt-3">' +
                    '<div class="col-12">' +
                        '<label class="form-label required small">Zoom Link</label>' +
                        '<input type="url" id="zoom_link" class="form-control" placeholder="https://zoom.us/j/...">' +
                    '</div>' +
                '</div>';
            parentRow.parentNode.insertBefore(div, parentRow.nextSibling);
        }
        // Reset values
        $('#date_interview_hr').val('');
        $('#time_interview_hr').val('');
        $('#zoom_link').val('');
        $('.btn-time-slot').removeClass('btn-danger').addClass('btn-outline-danger');
        $('#interview_hr_fields').show();

        // Slot tanggal (opsional, tetap disimpan untuk dipakai lagi):
        // var appId = $('#job_id').val();
        // if (appId) {
        //     $.ajax({
        //         url: "<?= base_url('recruitment/job_candidates/get_sla_interview_hr') ?>",
        //         method: "POST",
        //         data: { application_id: appId },
        //         dataType: "JSON",
        //         success: function(res) {
        //             if (!res.error) {
        //                 var btns = '';
        //                 var baseDate = new Date(res.min_date + 'T00:00:00');
        //                 var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        //                 for (var i = 0; i < res.sla_days; i++) {
        //                     var d = new Date(baseDate);
        //                     d.setDate(d.getDate() + i);
        //                     var yyyy = d.getFullYear();
        //                     var mm = ('0' + (d.getMonth() + 1)).slice(-2);
        //                     var dd = ('0' + d.getDate()).slice(-2);
        //                     var dateVal = yyyy + '-' + mm + '-' + dd;
        //                     var dayName = days[d.getDay()];
        //                     var label = dayName + ', ' + dd + '/' + mm + '/' + yyyy;
        //                     btns += '<button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 btn-date-slot" data-date="' + dateVal + '">' + label + '</button>';
        //                 }
        //                 $('#date_slots').html(btns);
        //             }
        //         }
        //     });
        // }
    }

    function save_status() {
        job_id = $('#job_id').val();
        status = $('#select_status').val();
        alasan = $('#select_alasan').val();

        var postData = {
            alasan: alasan,
            status: status,
            id: job_id
        };

        if (status == 10) {
            postData.date_interview_hr = $('#date_interview_hr').val();
            postData.time_interview_hr = $('#time_interview_hr').val();
            postData.zoom_link = $('#zoom_link').val();

            if (!postData.date_interview_hr || !postData.time_interview_hr || !postData.zoom_link) {
                error_alert('Lengkapi tanggal, jam, dan zoom link');
                return;
            }
        }

        $.ajax({
            url: "<?= base_url('recruitment/job_candidates/save_status') ?>",
            method: "POST",
            data: postData,
            dataType: "JSON",
            beforeSend: function() {
                $('#btn_save_status').attr('disabled', true);
            },
            success: function(res) {
                if (res.update == true) {
                    success_alert('Berhasil mengubah status');
                    $('#dt_jc').DataTable().ajax.reload();
                    $('#modal_edit_status').modal('hide');
                } else {
                    $('#btn_save_status').removeAttr('disabled');
                    error_alert('Gagal mengubah status');
                }
            },
            error: function(res) {
                console.log(res.responseText);
            }
        })
    }

    function delete_jc(id) {
        $.confirm({
            title: 'Delete Job Candidates',
            content: 'Job Candidates will be deleted',
            icon: 'fa fa-question',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action: function() {
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
                                    url: "<?= base_url('recruitment/job_candidates/delete_jc') ?>",
                                    method: "POST",
                                    data: {
                                        id: id
                                    },
                                    dataType: "JSON",
                                    beforeSend: function() {},
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'material',
                                        type: 'blue',
                                        content: 'Success!',
                                        buttons: {
                                            close: function() {},
                                        },
                                    });
                                    $('#dt_jc').DataTable().ajax.reload();
                                }).fail(function(jqXHR) {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-close',
                                        title: 'Oops!',
                                        theme: 'material',
                                        type: 'red',
                                        content: 'Failed to delete job candidates',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                });
                            },

                        });
                    }
                },
                cancel: function() {}
            }
        });
    }
    // Start Nice Select
    let select_status = NiceSelect.bind(document.getElementById('select_status'), {
        searchable: true,
        isAjax: false,
        after_change: function() {
            updateKeterangan();
        }
    });
    //End Nice Select 

    // Event delegation untuk time slot buttons
    $(document).on('click', '.btn-time-slot', function() {
        $('.btn-time-slot').removeClass('btn-danger').addClass('btn-outline-danger');
        $(this).removeClass('btn-outline-danger').addClass('btn-danger');
        $('#time_interview_hr').val($(this).data('time'));
    });

    // Event delegation untuk date slot buttons
    $(document).on('click', '.btn-date-slot', function() {
        $('.btn-date-slot').removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        $('#date_interview_hr').val($(this).data('date'));
    });
    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 2000,
        });
    }

    $(document).on('click', '.assign-test-btn', function() {
        var id = $(this).data('id');
        var id_user = $(this).data('id_user');
        var email = $(this).data('email');
        var access = $(this).data('access');
        $('#update_akses_test input[name="access[]"]').prop('checked', false);
        if (access) {
            const accessArray = access.toString().split(',');
            accessArray.forEach(function(id) {
                $('#update_akses_test input[value="' + id.trim() + '"]').prop('checked', true);
            });
        }
        $('#id_user_talent').val(id_user);
        $('#email_talent').val(email);
        $('#modal_akses_test').modal('show');
    });
    $('#update_akses_test').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.confirm({
            title: 'Are you Sure?!',
            content: 'Memberi akses test ke candidat tersebut?',
            icon: 'fa fa-question',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action: function() {
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
                                    url: "<?= base_url('recruitment/job_candidates/akses_test') ?>",
                                    method: "POST",
                                    data: form.serialize(),
                                    dataType: "JSON",
                                    beforeSend: function() {},
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'material',
                                        type: 'blue',
                                        content: 'Success!',
                                        buttons: {
                                            close: function() {},
                                        },
                                    });
                                    $('#modal_akses_test').modal('hide');
                                    $('#dt_jc').DataTable().ajax.reload();
                                }).fail(function(jqXHR) {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-close',
                                        title: 'Oops!',
                                        theme: 'material',
                                        type: 'red',
                                        content: 'Failed to delete job candidates',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                });
                            },

                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>


<script>
    // const bubbleTypewriter = document.getElementById('bubbleTypewriter');
    // const bubbleTypewriterP = document.getElementById('bubbleTypewriterP');

    // const texts = [
    //     "Hi, I’m Ella ",
    //     "I’ll be screening candidates in the background. Click my avatar to see recent matches."
    // ];

    // let i = 0;
    // let j = 0;
    // let currentText = '';

    // function typewriter() {
    //     if (i === texts.length) {
    //         i = 0;
    //     }

    //     currentText = texts[i];

    //     if (j < currentText.length) {
    //         bubbleTypewriter.textContent += currentText[j];
    //         bubbleTypewriterP.textContent += currentText[j];
    //         j++;
    //         setTimeout(typewriter, 20);
    //     } else {
    //         i++;
    //         j = 0;
    //         setTimeout(typewriter, 2000);
    //     }
    // }

    // typewriter();

    full_name = "<?= $this->session->userdata('nama'); ?>"

    const jikoshoukaiList = [
        "Halo " + full_name + ", senang bertemu Anda",
        "Saya adalah sahabat screening-mu yang siap bantu cari kandidat kece untuk tim impian.",
        "Panggil aku Ella! AI yang kerja cepat tanpa drama, cuma butuh kopi virtual biar makin semangat. ☕🤖",
        "Bersama kita temukan talenta terbaik demi masa depan perusahaan!",
        "Seleksi cepat, hasil tepat! Ella siap bantu Kamu biar nggak pusing screening CV yang numpuk. 📄➡✅",
        "Tugas utamaku? Biar kamu nggak harus baca CV sampai mimpiin format PDF. 😂"
    ];

    let currentText = "";
    let charIndex = 0;
    let jikoIndex = 0;

    function typeWriterEffect() {
        if (jikoIndex < jikoshoukaiList.length) {
            if (charIndex < jikoshoukaiList[jikoIndex].length) {
                currentText += jikoshoukaiList[jikoIndex].charAt(charIndex);
                document.getElementById("bubbleTypewriter").innerHTML = currentText;
                charIndex++;
                setTimeout(typeWriterEffect, 40);
            } else {
                setTimeout(() => {
                    jikoIndex++;
                    if (jikoIndex < jikoshoukaiList.length) {
                        currentText = "";
                        charIndex = 0;
                        typeWriterEffect();
                    } else {
                        bubble.style.opacity = '0';
                        bubble.style.transition = 'opacity 500ms';
                        setTimeout(() => bubble.style.display = 'none', 500);
                    }
                }, 1000);
            }
        }
    }

    window.onload = typeWriterEffect;
</script>
<script>
    // Sample data (in real app, populate from API)
    let recentMatches = [];

    const panel = document.getElementById('panel');
    const avatarBtn = document.getElementById('avatarBtn');
    const bubble = document.getElementById('bubble');
    const panelItems = document.getElementById('panelItems');
    const lastScanEl = document.getElementById('lastScan');
    const countScreened = document.getElementById('countScreened');

    // Initialize panel content
    function renderPanel() {
        $.ajax({
            url: "<?= base_url('recruitment/job_candidates/summary_ella') ?>",
            method: "POST",
            dataType: "JSON",
            dataType: "JSON",
            success: function(res) {
                countScreened.innerHTML = res.summary.total_screened;
                lastScanEl.innerHTML = res.summary.last_screened ? res.summary.last_screened : 'N/A';
                recentMatches.length = 0;
                recentMatches.push(...res.top_candidate);
                panelItems.innerHTML = '';
                recentMatches.forEach(m => {
                    const item = document.createElement('div');
                    item.className = 'item';
                    item.innerHTML = '<div style="display:flex;justify-content:space-between;align-items:center"><div><strong>' + escapeHtml(m.full_name) + '</strong><div class="muted" style="font-size:12px">' + escapeHtml(m.job_title) + '</div></div><div style="text-align:right"><strong>' + m.matching_total_score + '%</strong><div class="muted" style="font-size:12px">' + escapeHtml(m.status_score) + '</div></div></div>';
                    panelItems.appendChild(item);
                });
            }
        });
    }

    // Simple escape
    function escapeHtml(s) {
        return ('' + s).replace(/[&<>"'\/]/g, function(c) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;',
                '/': '&#47;'
            } [c];
        });
    }

    // show panel when avatar clicked
    avatarBtn.addEventListener('click', function() {
        if (panel.style.display === 'block') {
            panel.style.display = 'none';
        } else {
            renderPanel();
            panel.style.display = 'block';
        }
        // hide bubble after first interaction
        bubble.style.display = 'none';
    });

    // close button
    // document.getElementById('btnClosePanel').addEventListener('click', function() {
    //     panel.style.display = 'none';
    // });

    // actions
    // document.getElementById('btnViewReports').addEventListener('click', function() {
    //     alert('Open reports page (implement your routing).');
    // });
    // document.getElementById('btnRunScan').addEventListener('click', function() {
    //     // simulate quick scan
    //     this.disabled = true;
    //     this.textContent = 'Scanning...';
    //     setTimeout(() => {
    //         // update sample data
    //         recentMatches.unshift({
    //             name: 'New Candidate',
    //             role: 'Design Engineer',
    //             fit: 77,
    //             note: 'Good CAD skills, lacks field experience.'
    //         });
    //         if (recentMatches.length > 6) recentMatches.pop();
    //         renderPanel();
    //         document.getElementById('statScanned').textContent = Number(document.getElementById('statScanned').textContent) + 4;
    //         document.getElementById('countScreened').textContent = Number(document.getElementById('countScreened').textContent) + 4;
    //         lastScanEl.textContent = 'just now';
    //         this.disabled = false;
    //         this.textContent = 'Run quick scan';
    //     }, 1400);
    // });

    // initial bubble auto-hide after 4s
    setTimeout(() => {
        bubble.style.opacity = '0';
        bubble.style.transition = 'opacity 500ms';
        setTimeout(() => bubble.style.display = 'none', 500);
    }, 60000);

    // keyboard accessibility: press E to toggle panel
    document.addEventListener('keydown', function(e) {
        if (e.key.toLowerCase() === 'e') {
            avatarBtn.click();
        }
    });

    // initial render
    renderPanel();

    // // simulate background updates (for demo)
    // setInterval(() => {
    //     // randomly update some stats
    //     const scanned = Number(document.getElementById('statScanned').textContent) + (Math.random() > 0.7 ? 1 : 0);
    //     document.getElementById('statScanned').textContent = scanned;
    //     // update avg
    //     document.getElementById('statAvg').textContent = Math.max(60, Math.round((Math.random() * 30) + 60)) + '%';
    // }, 5000);

    $(document).ready(function() {
        $('.dropup').hide();
    });


    $('#btn_re_scan_candidate').on('click', function() {
        let application_id = $('#job_id').val();
        $.ajax({
            url: "https://n8n.trustcore.id/webhook/0d32da51-4ee6-4801-8308-99560677a461",
            method: "POST",
            data: {
                application_id: application_id
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#btn_re_scan_candidate').text('Scanning...');
                $('#btn_re_scan_candidate').attr('disabled', true);
            },
            success: function(res) {
                success_alert('Scan ulang berhasil dijalankan, tunggu beberapa 1-2 menit saat lagi untuk melihat hasilnya');
                $('#modal_edit_status').modal('hide');
                $('#btn_re_scan_candidate').removeAttr('disabled');
                $('#btn_re_scan_candidate').text('Scan Ulang');
            },
            error: function(res) {
                console.log(res.responseText);
            }
        })
    });
</script>