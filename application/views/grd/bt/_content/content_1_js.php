<script>
    $(document).ready(function() {
        pie_budget(1);
        reload_milestone();

        // console.log('Content 1 : ', $("#startCalendar").val(), $("#startCalendar").val());

        var startCalendar = $("#startCalendar").val();
        var endCalendar = $("#endCalendar").val();

        if (!startCalendar || !endCalendar) {
            var date = new Date();
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var currentDay = date;
            startCalendar = firstDay.toISOString().split('T')[0];
            endCalendar = currentDay.toISOString().split('T')[0];
        }

        console.log('Content 1 : ', startCalendar, endCalendar);
        
        get_data_prs_budget(startCalendar, endCalendar);


    });

    function get_data_prs_budget(start,end) {
        $.ajax({
            type: "POST",
            url: base_url + "data_persen_bt_budget",
            data: {
                // month: month,
                start: start,
                end: end
            },
            dataType: "json",
            success: function(response) {
                console.info(response.prs_bt_budget);
                pie_budget(response.prs_bt_budget);

                budget_awal_pe = parseInt(response.prs_bt_budget['budget_awal_pe']);
                budget_sisa_pe = response.prs_bt_budget['budget_sisa_pe'];
                budget_pemakaian_pe = parseInt(budget_awal_pe) - parseInt(budget_sisa_pe);
                $('#eaf_pengeluaran').text('Rp. ' + formatAngka(budget_pemakaian_pe) + ' / ' + formatAngka(budget_awal_pe));
                $('#eaf_pengeluaran_p').text(response.prs_bt_budget['budget_pe_p'] + '%');
                document.getElementById("eaf_pengeluaran_bar").style.width = response.prs_bt_budget['budget_pe_p'] + "%";
                document.getElementById("eaf_pengeluaran_bar").style.fontSize = "12px";

                budget_awal_sd = parseInt(response.prs_bt_budget['budget_awal_sd']);
                budget_sisa_sd = response.prs_bt_budget['budget_sisa_sd'];
                budget_pemakaian_sd = parseInt(budget_awal_sd) - parseInt(budget_sisa_sd);
                $('#eaf_sdm').text('Rp. ' + formatAngka(budget_pemakaian_sd) + ' / Rp.' + formatAngka(budget_awal_sd));
                $('#eaf_sdm_p').text(response.prs_bt_budget['budget_sd_p'] + '%');
                document.getElementById("eaf_produksi_bar").style.width = response.prs_bt_budget['budget_sd_p'] + "%";
                document.getElementById("eaf_produksi_bar").style.fontSize = "12px";

                budget_awal_pr = parseInt(response.prs_bt_budget['budget_awal_pr']);
                budget_sisa_pr = response.prs_bt_budget['budget_sisa_pr'];
                budget_pemakaian_pr = parseInt(budget_awal_pr) - parseInt(budget_sisa_pr);
                $('#eaf_produksi').text('Rp. ' + formatAngka(budget_pemakaian_pr) + ' / Rp.' + formatAngka(budget_awal_pr));
                $('#eaf_produksi_p').text(response.prs_bt_budget['budget_pr_p'] + '%');
                document.getElementById("eaf_produksi_bar").style.width = response.prs_bt_budget['budget_pr_p'] + "%";
                document.getElementById("eaf_produksi_bar").style.fontSize = "12px";

            }
        });
    }

    function pie_budget(data_budget) {
        $('#chart_pie_budget').empty().append(`
            <canvas id="pie_budget" style="width: 105px;"></canvas>`);
        const ctx = document.getElementById('pie_budget');

        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter = chart.getDatasetMeta(0).data[0].x;
                const yCenter = chart.getDatasetMeta(0).data[0].y;
                const innerRadius = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle = Math.PI / 180;

                // achieve
                ctx.font = 'bold 20px sans-serif';
                ctx.fillStyle = '#8D8D8D';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(data_budget.budget_all_p + '%', xCenter, yCenter);

                ctx.font = 'bold 14px sans-serif';
                ctx.fillText('Budget', xCenter, yCenter + 15);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Pengeluaran',
                    'Biaya SDM',
                    'Biaya Produksi'
                ],
                datasets: [{
                        // data: [
                        //     data_operasional.sales,
                        //     data_operasional.basket,
                        // ],
                        data: [
                            data_budget.budget_all_pe_prs,
                            data_budget.budget_all_pr_prs,
                            data_budget.budget_all_sd_prs,
                        ],
                        // data: [
                        //     60,
                        //     25,
                        //     15
                        // ],
                        borderColor: ['#081226', '#0B3281', '#2D6DEF'],
                        backgroundColor: ['#081226', '#0B3281', '#2D6DEF'],
                        cutout: '70%',
                    },

                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                        text: ''
                    },
                    doughnutPointer: {
                        pointerColorText: 'white',
                        pointerRadius: 5
                    },
                    datalabels: {
                        color: 'white',
                        formatter: (value, ctx) => {
                            // return value + '%';
                            return value;
                        }
                    }
                },
            },
            // plugins: [doughnutPointer, ChartDataLabels]
            plugins: [doughnutPointer]
        });
    }

    function reload_milestone() {
        fetch("<?= base_url('grd/bt/grd/getMilestones') ?>")
            .then(response => response.json())
            .then(data => {
                const ganttContent = document.getElementById("gantt-content");
                ganttContent.innerHTML = ""; // Clear existing content

                const totalMonths = 12;
                let occupiedRows = []; // Tracks which months are occupied

                data.forEach(milestone => {
                    const startDate = new Date(milestone.start);
                    const endDate = new Date(milestone.end);

                    const startMonth = startDate.getMonth(); // 0 = Jan, 11 = Dec
                    const endMonth = endDate.getMonth(); // 0 = Jan, 11 = Dec

                    // Calculate position and width
                    const startPercentage = (startMonth / totalMonths) * 100;
                    const durationPercentage = ((endMonth - startMonth + 1) / totalMonths) * 100;

                    // Find a free row for this milestone
                    let rowIndex = 0;
                    while (occupiedRows[rowIndex]?.some(month => month >= startMonth && month <= endMonth)) {
                        rowIndex++; // Move to the next row if the current row is occupied
                    }

                    // Mark months as occupied in the chosen row
                    if (!occupiedRows[rowIndex]) {
                        occupiedRows[rowIndex] = [];
                    }
                    for (let m = startMonth; m <= endMonth; m++) {
                        occupiedRows[rowIndex].push(m);
                    }

                    // Create a new row if needed
                    let ganttRow = document.getElementById(`gantt-row-${rowIndex}`);
                    if (!ganttRow) {
                        ganttRow = document.createElement("div");
                        ganttRow.classList.add("gantt-row");
                        ganttRow.id = `gantt-row-${rowIndex}`;
                        ganttRow.style.position = "relative";
                        ganttRow.style.height = "30px"; // Make space for multiple rows
                        ganttContent.appendChild(ganttRow);
                    }

                    // Create full grey bar for the entire duration
                    const fullBar = document.createElement("div");
                    fullBar.style.position = "absolute";
                    fullBar.style.left = `${startPercentage}%`;
                    fullBar.style.width = `${durationPercentage}%`;
                    fullBar.style.height = "20px";
                    fullBar.style.backgroundColor = "#F3F2F2"; // Grey color for uncompleted part
                    fullBar.style.borderRadius = "5px";
                    fullBar.style.top = "5px"; // Small padding
                    fullBar.style.pointerEvents = "none";

                    // Create progress bar on top of full grey bar
                    const milestoneBar = document.createElement("div");
                    milestoneBar.style.width = `${milestone.progress}%`; // Show only completed portion
                    milestoneBar.style.height = "100%"; // Full height of the grey bar
                    milestoneBar.style.backgroundColor = `#${milestone.warna}`;
                    milestoneBar.style.borderRadius = "5px";
                    milestoneBar.style.lineHeight = "20px";
                    milestoneBar.style.color = "black";
                    milestoneBar.style.textAlign = "center";
                    milestoneBar.style.fontSize = "9px";
                    milestoneBar.style.cursor = "pointer"; // Ensure pointer
                    milestoneBar.style.display = "block"; // Make sure it's a block element
                    milestoneBar.style.pointerEvents = "auto"; // Ensure it's interactive
                    milestoneBar.style.zIndex = "10"; // Bring it to the front
                    milestoneBar.style.minWidth = "10px"; // Ensure even small progress bars are clickable

                    // Set milestone label
                    const milestoneText = document.createElement("div");
                    milestoneText.style.cursor = "pointer";
                    milestoneText.style.position = "absolute";
                    milestoneText.style.left = `${startPercentage}%`;
                    milestoneText.style.width = `${durationPercentage}%`;
                    milestoneText.style.height = "20px";
                    milestoneText.style.lineHeight = "20px";
                    milestoneText.style.textAlign = "center";
                    milestoneText.style.fontSize = "8px";
                    milestoneText.style.fontWeight = "bold";
                    milestoneText.style.color = "black";
                    milestoneText.textContent = milestone.milestone + ' ' + milestone.progress + '%';

                    milestoneText.addEventListener("click", function() {
                        detail_milestone(milestone.id);
                        console.log('milestone bar clicked, id= ' + milestone.id);
                    });

                    // Append both elements to the Gantt row
                    fullBar.appendChild(milestoneBar);
                    ganttRow.appendChild(fullBar);
                    ganttRow.appendChild(milestoneText);

                });
            })
            .catch(error => console.error("Error fetching milestones:", error));
    }
</script>

<!-- DATA MILESTONE -->
<script>
    function dt_tasklist_milestone(data) {

        $('#table_task_milestone').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "data": data,
            "columns": [{
                    data: 'milestone',
                    'className': 'text-center'
                },
                {
                    data: 'detail',
                },
                {
                    data: 'pic',
                    // 'render': function(data, type, row, meta) {
                    //     avatar_pic = ``;
                    //     avatar_pic_plus = ``;
                    //     if (row['pp_peserta'].indexOf(',') > -1) {
                    //         array_pic = row['pp_peserta'].split(',');
                    //         for (let index = 0; index < array_pic.length; index++) {
                    //             if (index < 2) {
                    //                 avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                    //         <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                    //         </div>`;
                    //             }
                    //         }
                    //         if (array_pic.length > 2) {
                    //             avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                    //             <p class="small">${parseInt(array_pic.length)-2}+</p>
                    //         </div>`;
                    //         } else {
                    //             avatar_pic_plus = '';
                    //         }
                    //         return `<div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['peserta']}">
                    //             ${avatar_pic}${avatar_pic_plus}  
                    //         </div>`;
                    //     } else {
                    //         return `
                    //     <div class="row">
                    //         <div class="col-auto align-self-center">
                    //             <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}&quot;);">
                    //                 <img src="http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}" alt="" style="display: none;">
                    //             </figure>
                    //         </div>
                    //         <div class="col px-0 align-self-center">
                    //             <p class="mb-0 small">${row['peserta']}</p>
                    //         </div>
                    //     </div>`;
                    //     }
                    // },
                    // "className": "d-none d-md-table-cell text-left"
                },
                {
                    data: 'start'
                },
                {
                    data: 'end'
                },
                {
                    data: 'output'
                },
                {
                    data: 'target',
                },
                {
                    data: 'actual'
                },
                {
                    data: 'nama_status',
                    "render": function(data, type, row, meta) {
                        return `<a role="button" onclick="detail_task_milestone('${row['id_tasklist']}')" class="btn btn-sm btn-link" style="cursor:pointer;color:grey;background-color:${row['warna2']}">${row['nama_status']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    data: 'done_at'
                },
                {
                    data: 'done_at',
                },
                {
                    data: 'note'
                },
                {
                    data: 'evidence'
                },
                {
                    data: 'created_by'
                },
            ]
        });
    }

    function detail_milestone(milestoneId) {
        activateTabDet('update_milestone');

        var loadingDialog = $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Loading',
            theme: 'material',
            type: 'blue',
            content: 'Please wait, processing...',
            buttons: false, // Disable buttons
            closeIcon: false, // Disable close icon
        });

        $.ajax({
            type: "POST",
            url: base_url + 'get_detail_milestone',
            data: {
                id_milestone: milestoneId,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                updateTextWithPrefix("t_nama_milestone", "", response.header.milestone);
                $('#t_mile_company').text(response.header.nama_company);

                const elemen = document.getElementById("t_mile_progress");
                if (parseInt(response.header.progress) < 70) {
                    elemen.classList.remove("bg-success", "bg-primary", "bg-warning", "bg-danger");
                    elemen.classList.add("bg-danger");
                } else if (parseInt(response.header.progress) >= 70 && parseInt(response.header.progress) < 85) {
                    elemen.classList.remove("bg-success", "bg-primary", "bg-warning", "bg-danger");
                    elemen.classList.add("bg-warning");
                } else {
                    elemen.classList.remove("bg-success", "bg-primary", "bg-warning", "bg-danger");
                    elemen.classList.add("bg-success");
                }

                $('#t_mile_progress').text(response.header.progress);
                $('#t_mile_target').text(response.header.target);
                $('#t_mile_actual').val(response.header.actual);
                $('#t_mile_start').text(response.header.start);
                $('#t_mile_deadline').text(response.header.end);

                dt_tasklist_milestone(response.tasklist);
                loadingDialog.close();
                $('#modal_detail_milestone').appendTo('body').modal('show');
                $('#modal_detail_milestone').find('[name="t_id_milestone"]').val(response.header.id);
                $('#modal_detail_milestone').find('[name="t_target"]').val(response.header.target);

            }
        });

    }

    $('#form_update_milestone').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var divisi = $('#select_divisi').val();
        var month = $('#select_month').val();
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah anda yakin?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    var formData = new FormData(form[0]);
                    $.ajax({
                        type: "POST",
                        url: base_url + `/update_milestone`,
                        data: formData,
                        processData: false, // Jangan proses data, karena kita mengirim FormData
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            $('#modal_detail_milestone').modal('hide');
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                            reload_milestone();
                        }
                    });
                },
                close: {
                    actions: function() {
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });

    function detail_task_milestone(id_tasklist) {
        $("#modal_detail_milestone").modal("hide");
        $("#modal_tasklist_milestone").modal("show");

        activateTabDet('update_det');

        $.ajax({
            type: "POST",
            url: base_url + 'get_milestone_task',
            data: {
                id_tasklist: id_tasklist,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                updateTextWithPrefix("det_nama_milestone", "Milestone: ", response.header.milestone);
                // $('#det_nama_company').text(response.header.company);
                $('#det_divisi').text(response.header.divisi);
                $('#det_status').text(response.header.nama_status);
                $('#det_status').removeClass().addClass(`badge fs-6 ${response.header.warna}`);
                $('#det_detail').text(response.header.detail);
                $('#det_pic').text(response.header.pic);
                $('#det_start').text(response.header.start);
                $('#det_deadline').text(response.header.end);
                $('#det_output').text(response.header.output);
                $('#det_target').text(response.header.target + " (" + response.header.target_milestone_type + ")");
                $('#det_status').val(response.header.status);
                $('#det_status_before').val(response.header.status);
                $('#det_actual').val(response.header.actual);
                $('#det_note').val('');
                $('#det_evidence').val('');

                $('#det_target_milestone').val(response.header.target);
                $('#det_target_milestone_type').val(response.header.target_milestone_type);
                $('#det_actual_milestone_type').val(response.header.actual_milestone_type);


                $('#modal_tasklist_milestone').appendTo('body').modal('show');
                $('#modal_tasklist_milestone').find('[name="det_id_tasklist"]').val(response.header.id_tasklist);
                load_all_tab_det();
            }
        });

    }

    $('#form_update_tasklist_milestone').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var divisi = $('#select_divisi').val();
        var month = $('#select_month').val();
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah anda yakin?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    var formData = new FormData(form[0]);
                    $.ajax({
                        type: "POST",
                        url: base_url + `update_task_milestone`,
                        data: formData,
                        processData: false, // Jangan proses data, karena kita mengirim FormData
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            console.info("response : " + response);
                            loadingDialog.close();
                            $('#modal_tasklist_milestone').modal('hide');
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                            reload_milestone();
                        }
                    });
                },
                close: {
                    actions: function() {
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });

    function activateTabDet(tabId) {
        if (tabId == 'activity_det') {
            load_all_tab_det();
        }

        // Menghapus class 'active' dari semua tab dan konten
        $(".nav-link").removeClass("active");
        $(".tab-pane").removeClass("show active");

        // Menambahkan class 'active' ke tab yang dipilih
        $("#nav_" + tabId).addClass("active");

        // Menampilkan konten yang sesuai
        $("#tab_" + tabId).addClass("show active");

    }

    function load_all_tab_det() {
        var id_tasklist = $('#form_update_tasklist_milestone').find('[name="det_id_tasklist"]').val();

        $.ajax({
            type: "POST",
            url: base_url + "load_all_tab_det",
            data: {
                'id_tasklist': id_tasklist
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                var history = ``;
                var file = ``;
                response.history.forEach((value) => {
                    if (value.status == value.status_before) {

                        history += `
                                    <tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-chat-quote text-primary"></i>Note</td>
                                        <td class="small">${value.note}</td>
                                    </tr>
                                    `;
                    } else {

                        history += `<tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-bookmark text-primary"></i>Status</td>
                                        <td class="small"><span class="badge ${value.st_before_warna}">${value.st_before}</span> > <span class="badge ${value.st_warna}">${value.st}</span></td>
                                    </tr>
                                    <tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-chat-quote text-primary"></i>Note</td>
                                        <td class="small">${value.note}</td>
                                    </tr>
                                    `;
                    }
                });
                $('#tabel_activity_detail').empty().append(history);
                if (response.file.length == 0) {
                    $('#tabel_files_detail').empty();
                } else {
                    response.file.forEach((value) => {
                        file += `<div class="card border-0 overflow-hidden">
                                    <div class="h-130 bg-red text-white d-flex align-items-center">
                                        <h1 class="col-12 text-center"><i class="bi bi-file-earmark-pdf"></i> PDF</h1>
                                    </div>
                                    <div class="card-footer bg-none">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-12">
                                                <a href="<?= base_url(''); ?>/uploads/grd/evidence/${value.evidence}" target="_blank" class="avatar avatar-30 rounded text-red mr-3 w-100">
                                                    <i class="bi bi-download h5 vm"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    });
                    $('#tabel_files_detail').empty().append(file);
                }
            }
        });
    }
</script>

<!-- Add new task GRD -->
<script>
    const add_id_company = new SlimSelect({
        select: "#add_id_company",
        settings: {
            allowDeselect: true
        }
    });
    const add_id_goal = new SlimSelect({
        select: "#add_id_goal",
        settings: {
            allowDeselect: true
        }
    });
    const add_id_so = new SlimSelect({
        select: "#add_id_so",
        settings: {
            allowDeselect: true
        }
    });
    const add_id_si = new SlimSelect({
        select: "#add_id_si",
        settings: {
            allowDeselect: true
        }
    });
    const add_id_pic = new SlimSelect({
        select: "#add_id_pic",
        settings: {
            allowDeselect: true
        }
    });

    const add_id_jenis = new SlimSelect({
        select: "#add_id_jenis",
        settings: {
            allowDeselect: true
        }
    });
    
    const add_id_week = new SlimSelect({
        select: "#add_id_week",
        settings: {
            allowDeselect: true
        }
    });


    function add_new_task() {
        $('#modal_add_task').modal('show');
        // $('#add_id_company').dropdown_se('clear');
        // $('#add_id_divisi').dropdown_se('clear');
        // $('#add_id_goal').dropdown_se('clear');
        // $('#add_id_so').dropdown_se('clear');
        // $('#add_id_si').dropdown_se('clear');
        // $('#add_id_pic').dropdown_se('clear');
        $('#start').val('');
        $('#end').val('');
        $('#detail').val('');
        $('#output').val('');
        $('#target').val('');

        get_company();
        // get_divisi();
    }
</script>

<!-- Add new task Milestone -->
<script>
    const mile_id_company = new SlimSelect({
        select: "#mile_id_company",
        settings: {
            allowDeselect: true
        }
    });
    const mile_id_milestone = new SlimSelect({
        select: "#mile_id_milestone",
        settings: {
            allowDeselect: true
        }
    });

    const mile_id_pic = new SlimSelect({
        select: "#mile_id_pic",
        settings: {
            allowDeselect: true
        }
    });


    function add_new_task_milestone() {
        $('#modal_add_task_milestone').modal('show');
        // $('#mile_id_company').dropdown_se('clear');
        // $('#mile_id_milestone').dropdown_se('clear');
        // $('#mile_id_pic').dropdown_se('clear');
        $('#start').val('');
        $('#end').val('');
        $('#detail').val('');
        $('#output').val('');
        $('#target').val('');

        mile_get_company();
        // get_divisi();
    }
</script>

<!-- Modal Add Task GRD Open -->
<script>
    function get_company() {
        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/get_company',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            add_id_company.setData([{
                text: '- Pilih Company -',
                value: '',
                disabled: true,
                selected: true
            }, ...response.map(comp => ({
                text: comp.name,
                value: comp.company_id
            }))]);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Data")
        });
    }

    $('#add_id_divisi').change(function(e) {
        e.preventDefault();
        var add_id_divisi = $(this).val();
        if (add_id_divisi == null) {
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/goal_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_divisi: add_id_divisi
            },
            success: function(response) {
                add_id_goal.setData([]); // Reset options
                add_id_pic.setData([]); // Reset options
                add_id_so.setData([]);

                add_id_goal.setData([{
                    text: '- Pilih Goal -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.goals.map(value => ({
                    text: `${value.nama_goal} - ${value.periode}`,
                    value: value.id_goal
                }))]);
                add_id_pic.setData(response.pic.map(value => ({
                    text: value.pic_name,
                    value: value.user_id
                })));
                // add_id_goal.update();

            },
            error: function(xhr) { // if error occured

            },

        });


    });

    $('#add_id_goal').change(function(e) {
        e.preventDefault();
        var id_goal = $('#add_id_goal').val();

        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/get_so_by_goal',
            type: 'POST',
            dataType: 'json',
            data: {
                id_goal: id_goal
            },
            success: function(response) {
                add_id_so.setData([{
                    text: '- Pilih SO -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.map(value => ({
                    text: `${value.so} | ${value.periode}`,
                    value: value.id_so
                }))]);
                // add_id_so.update();
            },
            error: function(xhr) { // if error occured

            },

        });
    });

    $('#add_id_so').change(function(e) {
        e.preventDefault();
        var id_so = $('#add_id_so').val();

        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/get_si_by_so',
            type: 'POST',
            dataType: 'json',
            data: {
                id_so: id_so
            },
            success: function(response) {
                add_id_si.setData([{
                    text: '- Pilih SI -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.map(value => ({
                    text: value.si,
                    value: value.id_si
                }))]);
                // add_id_si.update();
            },
            error: function(xhr) { // if error occured

            },

        });
    });

    $('#add_id_jenis').change(function(e) {
        var add_id_jenis = $('#add_id_jenis').val();
        if (add_id_jenis == "Weekly") {
            $('#add_id_jenis_div').removeClass('col-md-12').addClass('col-md-6');
            $('#add_id_jenis_div').removeClass('col-lg-12').addClass('col-lg-6');
            $('#add_id_week_div').show('swing');
            $("#start").datepicker("destroy").val('');
            $("#start").datepicker({
                startDate: new Date(),
                format: "yyyy-mm-dd",
                beforeShowDay: function (d) {
                    var day = d.getDay();
                    return day == 1;
                },
            });
            $("#end").val('').attr("style", "pointer-events: none;background-color: rgba(75,70,92,.08);");
            $(`#label_detail`).text('Detail Pekerjaan Minggu ke-1');
        } else {
            $('#add_id_jenis_div').addClass('col-md-12').removeClass('col-md-6');
            $('#add_id_jenis_div').addClass('col-lg-12').removeClass('col-lg-6');
            $('#add_id_week_div').hide('swing');
            $("#start").datepicker("destroy").val('');
            $("#start").datepicker({
                startDate: new Date(),
                autoclose: true,
                format: "yyyy-mm-dd",
            });
            $("#end").val('').attr("style", "pointer-events: auto;");
            for (let i = 1; i < 6; i++) {
                $(`#add_id_detail_div${i}`).remove();
            }
            $(`#label_detail`).text('Detail Pekerjaan');
        }
    });

    
    $('#add_id_week').change(function(e) {
        var add_id_week = $('#add_id_week').val();
        if ($('#start').val() != '') {
            var start = $('#start').val();
            var end = new Date(start);
            end.setDate(end.getDate() + add_id_week * 7 - 1);
            $("#end").val(end.toISOString().split('T')[0]);
        }
        for (let i = 0; i < 6; i++) {
            $(`#add_id_detail_div${i}`).remove();
        }
        for (let i = 0; i < add_id_week; i++) {
            var new_detail = `
                <div class="mb-2 col-12 col-md-12" id="add_id_detail_div${i}">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label-custom required small mb-1" for="detail${i == 0 ? '' : i}" id="label_detail${i == 0 ? '' : i}">Detail Pekerjaan Minggu ke-${i + 1}</label>
                                <div class="input-group border-custom mb-3">
                                    <span class="input-group-text bi bi-file-earmark-font"></span>
                                    <input type="text" class="form-control border-custom" name="detail[]" id="detail${i == 0 ? '' : i}" placeholder="Detail Pekerjaan">
                                </div>

                                <label class="form-label-custom required small mb-1" for="output${i == 0 ? '' : i}">Output</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-award"></span>
                                    <input type="text" class="form-control border-custom" name="output[]" id="output${i == 0 ? '' : i}" placeholder="Output Pekerjaan">
                                </div>

                                <label class="form-label-custom small mb-1" for="target${i == 0 ? '' : i}">Target</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="number" class="form-control border-custom" name="target[]" id="target${i == 0 ? '' : i}" placeholder="Target Pencapaian Pekerjaan, contoh: 100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            $(`#add_id_detail_row`).append(new_detail);
        }
    });

    $('#start').change(function(e) {
        var start = $('#start').val();
        var nextDate = new Date(start);
        nextDate.setDate(nextDate.getDate() + 1);
        $("#end").datepicker("destroy").val('');
        $("#end").datepicker({
            startDate: nextDate,
            autoclose: true,
            format: "yyyy-mm-dd",
        });
        if ($('#add_id_jenis').val() == "Weekly") {
            var add_id_week = $('#add_id_week').val();
            var end = new Date(start);
            end.setDate(end.getDate() + add_id_week * 7-1);
            $("#end").val(end.toISOString().split('T')[0]);
        }
    });
</script>
<!-- Modal Add Task GRD Open End -->

<!-- Modal Add Task Milestone Open -->
<script>
    function mile_get_company() {
        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/get_company',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            mile_id_company.setData([{
                text: '- Pilih Company -',
                value: '',
                disabled: true,
                selected: true
            }, ...response.map(comp => ({
                text: comp.name,
                value: comp.company_id
            }))]);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Data")
        });
    }

    $('#mile_id_company').change(function(e) {
        e.preventDefault();
        var mile_id_company = $(this).val();
        if (mile_id_company == null) {
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/milestone_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_company: mile_id_company
            },
            success: function(response) {
                mile_id_milestone.setData([]); // Reset options
                mile_id_pic.setData([]); // Reset options

                mile_id_milestone.setData([{
                    text: '- Pilih Milestone -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.milestone.map(value => ({
                    text: value.milestone,
                    value: value.id
                }))]);
                mile_id_pic.setData(response.pic.map(value => ({
                    text: value.pic_name,
                    value: value.user_id
                })));
                // mile_id_milestone.update();

            },
            error: function(xhr) { // if error occured

            },

        });


    });
</script>
<!-- Modal Add Task Milestone Open End -->

<!-- Save Task GRD Start -->
<script>
    function save_task() {
        let val_id_divisi = $('#add_id_divisi').val();
        let val_id_si = $('#add_id_si').val();
        let val_id_pic = $('#add_id_pic').val();
        let val_id_jenis = $('#add_id_jenis').val();
        let val_id_week = $('#add_id_week').val();
        let val_start = $('#start').val();
        let val_end = $('#end').val();
        let val_detail = [];
        $("input[name='detail[]']").each(function() { val_detail.push($(this).val()); });
        let val_output = [];
        $("input[name='output[]']").each(function() { val_output.push($(this).val()); });
        let val_target = [];
        $("input[name='target[]']").each(function() { val_target.push($(this).val()); });
        console.log('val_detail = ' + val_detail);
        console.log('val_output = ' + val_output);
        console.log('val_target = ' + val_target);
        
        console.log('id pic = ' + val_id_pic);



        if (val_id_divisi == "" || val_id_divisi == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Divisi must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_si == "" || val_id_si == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, SI must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_pic == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, pic must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_jenis == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, jenis tasklist must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_week == "" && val_id_jenis == "Weekly") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, jumlah minggu must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_start == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, tanggal mulai must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_end == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, deadline must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_detail.includes("")) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, detail tasklist must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_output.includes("")) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, output must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah anda yakin?',
                buttons: {
                    confirm: function() {
                        let form_data_tasklist = new FormData();
                        form_data_tasklist.append("divisi", val_id_divisi);
                        form_data_tasklist.append("id_si", val_id_si);
                        form_data_tasklist.append("id_pic", val_id_pic.toString());
                        form_data_tasklist.append("jenis", val_id_jenis);
                        form_data_tasklist.append("week", val_id_week);
                        form_data_tasklist.append("start", val_start);
                        form_data_tasklist.append("end", val_end);
                        form_data_tasklist.append("detail", val_id_jenis == "Weekly" ? JSON.stringify(val_detail) : val_detail);
                        form_data_tasklist.append("output", val_id_jenis == "Weekly" ? JSON.stringify(val_output) : val_output);
                        form_data_tasklist.append("target", val_id_jenis == "Weekly" ? JSON.stringify(val_target) : val_target);

                        $.ajax({
                            url: `<?= base_url() ?>grd/bt/grd/save_task`,
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data_tasklist, // Setting the data attribute of ajax with file_data
                            type: 'post',
                            dataType: 'json',
                            beforeSend: function() {

                            },
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(response) {
                            console.log(response.save_task);
                            if (response.save_task == true) {
                                $('#modal_add_task').modal('hide');
                                reload_data(); //reload disini
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'material',
                                        type: 'blue',
                                        content: 'Success! Membuat Tasklist GRD',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            } else {
                                $('#modal_add_task').modal('hide');

                                //reload table disini

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
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            }
                        }).fail(function(jqXHR, textStatus) {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-close',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Failed! ' + textStatus,
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                        });
                    },
                    close: {
                        actions: function() {
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
        }
    }
</script>
<!-- Save Task GRD End  -->

<!-- Save Task Milestone Start -->
<script>
    function save_task_milestone() {
        let val_id_company = $('#mile_id_company').val();
        let val_id_divisi = $('#mile_id_divisi').val();
        let val_id_milestone = $('#mile_id_milestone').val();
        let val_id_pic = $('#mile_id_pic').val();
        let val_start = $('#mile_start').val();
        let val_end = $('#mile_end').val();
        let val_detail = $('#mile_detail').val();
        let val_output = $('#mile_output').val();
        let val_target = $('#mile_target').val();

        console.log('id pic = ' + val_id_pic);

        if (val_id_company == "" || val_id_company == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Company must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_divisi == "" || val_id_divisi == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Divisi must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_milestone == "" || val_id_milestone == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Milestone must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_pic == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, pic must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_start == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, tanggal mulai must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_end == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, deadline must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_detail == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, detail tasklist must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_output == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, output must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah anda yakin?',
                buttons: {
                    confirm: function() {
                        let form_data_tasklist = new FormData();
                        form_data_tasklist.append("divisi", val_id_divisi);
                        form_data_tasklist.append("id_milestone", val_id_milestone);
                        form_data_tasklist.append("id_pic", val_id_pic.toString());
                        form_data_tasklist.append("start", val_start);
                        form_data_tasklist.append("end", val_end);
                        form_data_tasklist.append("detail", val_detail);
                        form_data_tasklist.append("output", val_output);
                        form_data_tasklist.append("target", val_target);

                        $.ajax({
                            url: `<?= base_url() ?>grd/bt/grd/save_task_milestone`,
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data_tasklist, // Setting the data attribute of ajax with file_data
                            type: 'post',
                            dataType: 'json',
                            beforeSend: function() {

                            },
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(response) {
                            console.log(response.save_task);
                            if (response.save_task == true) {

                                $('#modal_add_task_milestone').modal('hide');
                                reload_data(); //reload disini

                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'material',
                                        type: 'blue',
                                        content: 'Success! Membuat Tasklist Milestone',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            } else {
                                $('#modal_add_task_milestone').modal('hide');

                                //reload table disini

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
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            }
                        }).fail(function(jqXHR, textStatus) {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-close',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Failed! ' + textStatus,
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                        });
                    },
                    close: {
                        actions: function() {
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
        }
    }

    function formatAngka(angka) {
        if (angka >= 1_000_000_000_000) {
            return (angka / 1_000_000_000_000).toFixed(2) + 'T'; // Triliun
        } else if (angka >= 1_000_000_000) {
            return (angka / 1_000_000_000).toFixed(2) + 'M'; // Miliar
        } else {
            return angka.toLocaleString(); // Format ribuan biasa
        }
    }
</script>
<!-- Save Task Milestone End  -->


<!-- inputan SO -->
<script>
    const so_id_company = new SlimSelect({
        select: "#so_id_company",
        settings: {
            allowDeselect: true
        }
    });
    const so_id_goal = new SlimSelect({
        select: "#so_id_goal",
        settings: {
            allowDeselect: true
        }
    });

    // const so_id_so = new SlimSelect({
    //     select: "#so_id_so",
    //     settings: {
    //         allowDeselect: true
    //     }
    // });

    const so_id_pic = new SlimSelect({
        select: "#so_id_pic",
        settings: {
            allowDeselect: true
        }
    });

    function add_new_so() {
        $('#modal_add_so').modal('show');
        $('#so_start').val('');
        $('#so_end').val('');
        $('#so_target').val('');
        $('#so_target_so_type').val('');

        get_company_so();
    }
</script>

<script>
    function get_company_so() {
        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/get_company',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            so_id_company.setData([{
                text: '- Pilih Company -',
                value: '',
                disabled: true,
                selected: true
            }, ...response.map(comp => ({
                text: comp.name,
                value: comp.company_id
            }))]);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Data")
        });
    }

    $('#so_id_divisi').change(function(e) {
        e.preventDefault();
        var so_id_divisi = $(this).val();
        if (so_id_divisi == null) {
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/goal_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_divisi: so_id_divisi
            },
            success: function(response) {
                so_id_goal.setData([]); // Reset options
                so_id_pic.setData([]); // Reset options
                // so_id_so.setData([]);

                so_id_goal.setData([{
                    text: '- Pilih Goal -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.goals.map(value => ({
                    text: `${value.nama_goal} - ${value.periode}`,
                    value: value.id_goal
                }))]);
                so_id_pic.setData(response.pic.map(value => ({
                    text: value.pic_name,
                    value: value.user_id
                })));
                // so_id_goal.update();

            },
            error: function(xhr) { // if error occured

            },

        });


    });

    // $('#so_id_goal').change(function(e) {
    //     e.preventDefault();
    //     var id_goal_so = $('#so_id_goal').val();

    //     $.ajax({
    //         url: '<?= base_url() ?>grd/bt/grd/get_so_by_goal',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {
    //             id_goal: id_goal_so
    //         },
    //         success: function(response) {
    //             so_id_so.setData([{
    //                 text: '- Pilih SO -',
    //                 value: '',
    //                 disabled: true,
    //                 selected: true
    //             }, ...response.map(value => ({
    //                 text: value.so,
    //                 value: value.id_so
    //             }))]);
    //             // add_id_so_so.update();
    //         },
    //         error: function(xhr) { // if error occured

    //         },

    //     });
    // });
</script>

<script>
    function save_so() {
        let val_id_divisi   = $('#so_id_divisi').val();
        let val_id_company  = $('#so_id_company').val();
        let val_id_goal     = $('#so_id_goal').val();
        let val_id_so       = $('#so_id_so').val();
        let val_id_pic      = $('#so_id_pic').val();
        let val_start       = $('#so_start').val();
        let val_end         = $('#so_end').val();
        let val_target      = $('#so_target').val();
        let val_target_type = $('#so_target_so_type').val();
        let val_actual_type = $('#so_actual_so_type').val();

        console.log('id pic = ' + val_id_pic);
        console.log('id divisi = ' + val_id_divisi);

        if (val_id_divisi == "" || val_id_divisi == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Divisi must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_company == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Company must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_goal == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Goal must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_so == "" || val_id_so == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, SO must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_pic == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, PIC must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_start == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, tanggal mulai must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_end == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, deadline must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_target == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, target must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_target_type == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, target so type must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_actual_type == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, actual so type must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah anda yakin?',
                buttons: {
                    confirm: function() {
                        let form_data_so = new FormData();
                        form_data_so.append("so_id_divisi", val_id_divisi);
                        form_data_so.append("so_id_company", val_id_company);
                        form_data_so.append("so_id_goal", val_id_goal);
                        form_data_so.append("so_id_so", val_id_so);
                        form_data_so.append("so_id_pic", val_id_pic.toString());
                        form_data_so.append("so_start", val_start);
                        form_data_so.append("so_end", val_end);
                        form_data_so.append("so_target", val_target);
                        form_data_so.append("so_target_so_type", val_target_type);
                        form_data_so.append("so_actual_so_type", val_actual_type);

                        $.ajax({
                            url: `<?= base_url() ?>grd/bt/grd/save_so`,
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data_so, // Setting the data attribute of ajax with file_data
                            type: 'post',
                            dataType: 'json',
                            beforeSend: function() {

                            },
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(response) {
                            console.log(response.save_so);
                            if (response.save_so == true) {
                                $('#modal_add_so').modal('hide');
                                reload_data(); //reload disini
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'material',
                                        type: 'blue',
                                        content: 'Success! Membuat SO GRD',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            } else {
                                $('#modal_add_so').modal('hide');

                                //reload table disini

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
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            }
                        }).fail(function(jqXHR, textStatus) {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-close',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Failed! ' + textStatus,
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                        });
                    },
                    close: {
                        actions: function() {
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
        }
    }
</script>

<!-- inputan SI -->
<script>
    const si_id_company = new SlimSelect({
        select: "#si_id_company",
        settings: {
            allowDeselect: true
        }
    });
    const si_id_goal = new SlimSelect({
        select: "#si_id_goal",
        settings: {
            allowDeselect: true
        }
    });

    const si_id_so = new SlimSelect({
        select: "#si_id_so",
        settings: {
            allowDeselect: true
        }
    });

    const si_id_pic = new SlimSelect({
        select: "#si_id_pic",
        settings: {
            allowDeselect: true
        }
    });

    function add_new_si() {
        $('#modal_add_si').modal('show');
        $('#si_start').val('');
        $('#si_end').val('');
        $('#si_target').val('');
        $('#si_target_si_type').val('');

        get_company_si();
    }
</script>

<script>
    function get_company_si() {
        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/get_company',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            si_id_company.setData([{
                text: '- Pilih Company -',
                value: '',
                disabled: true,
                selected: true
            }, ...response.map(comp => ({
                text: comp.name,
                value: comp.company_id
            }))]);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Data")
        });
    }

    $('#si_id_divisi').change(function(e) {
        e.preventDefault();
        var si_id_divisi = $(this).val();
        if (si_id_divisi == null) {
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/goal_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_divisi: si_id_divisi
            },
            success: function(response) {
                si_id_goal.setData([]); // Reset options
                si_id_pic.setData([]); // Reset options
                si_id_so.setData([]);

                si_id_goal.setData([{
                    text: '- Pilih Goal -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.goals.map(value => ({
                    text: `${value.nama_goal} - ${value.periode}`,
                    value: value.id_goal
                }))]);
                si_id_pic.setData(response.pic.map(value => ({
                    text: value.pic_name,
                    value: value.user_id
                })));
                // si_id_goal.update();

            },
            error: function(xhr) { // if error occured

            },

        });


    });

    $('#si_id_goal').change(function(e) {
        e.preventDefault();
        var si_id_goal = $('#si_id_goal').val();

        $.ajax({
            url: '<?= base_url() ?>grd/bt/grd/get_so_by_goal',
            type: 'POST',
            dataType: 'json',
            data: {
                id_goal: si_id_goal
            },
            success: function(response) {
                si_id_so.setData([{
                    text: '- Pilih SO -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.map(value => ({
                    text: value.so,
                    value: value.id_so
                }))]);
                // add_id_so_so.update();
            },
            error: function(xhr) { // if error occured

            },

        });
    });
</script>

<script>
    function save_si() {
        let val_id_divisi   = $('#si_id_divisi').val();
        let val_id_company  = $('#si_id_company').val();
        let val_id_goal     = $('#si_id_goal').val();
        let val_id_so       = $('#si_id_so').val();
        let val_id_si       = $('#si_id_si').val();
        let val_id_pic      = $('#si_id_pic').val();
        let val_start       = $('#si_start').val();
        let val_end         = $('#si_end').val();
        let val_target      = $('#si_target').val();
        let val_target_type = $('#si_target_si_type').val();
        let val_actual_type = $('#si_actual_si_type').val();

        console.log('id pic = ' + val_id_pic);
        console.log('id divisi = ' + val_id_divisi);

        if (val_id_divisi == "" || val_id_divisi == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Divisi must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_company == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Company must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_goal == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Goal must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_so == "" || val_id_so == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, SO must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_si == "" || val_id_si == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, SI must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_pic == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, PIC must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_start == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, tanggal mulai must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_end == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, deadline must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_target == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, target must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_target_type == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, target SI type must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_actual_type == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, actual SI type must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah anda yakin?',
                buttons: {
                    confirm: function() {
                        let form_data_si = new FormData();
                        form_data_si.append("si_id_divisi", val_id_divisi);
                        form_data_si.append("si_id_company", val_id_company);
                        form_data_si.append("si_id_goal", val_id_goal);
                        form_data_si.append("si_id_so", val_id_so);
                        form_data_si.append("si_id_si", val_id_si);
                        form_data_si.append("si_id_pic", val_id_pic.toString());
                        form_data_si.append("si_start", val_start);
                        form_data_si.append("si_end", val_end);
                        form_data_si.append("si_target", val_target);
                        form_data_si.append("si_target_si_type", val_target_type);
                        form_data_si.append("si_actual_si_type", val_actual_type);

                        $.ajax({
                            url: `<?= base_url() ?>grd/bt/grd/save_si`,
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data_si, // Setting the data attribute of ajax with file_data
                            type: 'post',
                            dataType: 'json',
                            beforeSend: function() {

                            },
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(response) {
                            console.log(response.save_si);
                            if (response.save_si == true) {
                                $('#modal_add_si').modal('hide');
                                reload_data(); //reload disini
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'material',
                                        type: 'blue',
                                        content: 'Success! Membuat SI GRD',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            } else {
                                $('#modal_add_si').modal('hide');

                                //reload table disini

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
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            }
                        }).fail(function(jqXHR, textStatus) {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-close',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Failed! ' + textStatus,
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                        });
                    },
                    close: {
                        actions: function() {
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
        }
    }
</script>