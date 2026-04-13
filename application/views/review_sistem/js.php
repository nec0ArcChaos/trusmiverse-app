<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
</link>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script>
    $(document).ready(function() {
        setDates()
        // var year = dtToday.getFullYear();
        // if (month < 10)
        //     month = '0' + month.toString();
        // if (day < 10)
        //     day = '0' + day.toString();

        // var maxDate = year + '-' + month + '-' + day;
        // alert(maxDate);
        // $('#tgl_masuk').attr('min', maxDate);

        // Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
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


        dt_review_all('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        dt_list_detail('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>')


        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_review_all(start, end);
            dt_list_detail(start, end);

        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_review_all(start, end);
            dt_list_detail(start, end);
        })

        $('#kesesuaian_uiux').on('change', function() {
            st = $('#kesesuaian_uiux').val();

            console.log('status:', st);

            if (st == 'Sesuai') {
                $('#div_uiux').hide();
            } else {
                $('#div_uiux').show();
            }
        })



    });

    // setting baseurl 
    var baseurl = "<?= base_url('work_on_holiday') ?>"
    var baseurl2 = "<?= base_url('review_sistem') ?>"

    // setting library
    let impact = $('#impact').summernote({
        placeholder: 'Input here...',
        tabsize: 10,
        height: 100,
        toolbar: false
    });
    impact.summernote('code', '');

    let note = $('#note').summernote({
        placeholder: 'Input here...',
        tabsize: 10,
        height: 100,
        toolbar: false
    });
    note.summernote('code', '');

    let improvement = $('#improvement').summernote({
        placeholder: 'Input here...',
        tabsize: 10,
        height: 100,
        toolbar: false
    });
    improvement.summernote('code', '');

    let ui = $('#ui').summernote({
        placeholder: 'Input here...',
        tabsize: 10,
        height: 100,
        toolbar: false
    });

    // preset layout / struktur
    ui.summernote('code', `
    Layout / Struktur : <br>
    Teks & Data : 
    `);


    let ux = $('#ux').summernote({
        placeholder: 'Input here...',
        tabsize: 10,
        height: 100,
        toolbar: false
    });

    // preset layout / struktur
    ux.summernote('code', `
    Alur Penggunaan SIstem : <br>
    Kemudahan Menggunakan Fitur : 
    `);

    function setDates() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var deadline = dtToday.getDate() + 1
        var dtToday = new Date(); // Tanggal hari ini
        var dtTomorrow = new Date(dtToday); // Salin objek Date
        dtTomorrow.setDate(dtTomorrow.getDate() + 1); // Tambahkan 1 hari

        // Format tanggal menjadi YYYY-MM-DD
        var formattedDate = dtTomorrow.getFullYear() + '-' +
            String(dtTomorrow.getMonth() + 1).padStart(2, '0') + '-' +
            String(dtTomorrow.getDate()).padStart(2, '0');

        // Set nilai pada elemen dengan ID #deadline_head
        $("#deadline_head").val(formattedDate);
    }

    function list_detail(id) {
        $('#dt_detail').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'Data Review System ' + start,
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseurl2}/get_detail`,
                "data": {
                    id
                }
            },
            "columns": [

                {
                    'data': 'company',
                    'className': 'text-center'
                },
                {
                    'data': 'department',
                },
                {
                    'data': 'head_name',
                },
                {
                    'data': 'pic_name',
                },
                {
                    'data': 'deadline_pic',
                },
                {
                    'data': 'status',
                },
                {
                    'data': 'kepuasan_aplikasi',
                    "render": function(data, type, row, meta) {
                        if (data == null) {
                            return ``
                        } else {
                            stars = '';
                            for (let i = 0; i < data; i++) {
                                stars += `<span class = "stars-list">★</span>`;
                            }
                            return `<div class="stars-box">${stars}</div>`;
                        }
                    }
                },
                {
                    'data': 'kesesuaian_aplikasi',
                },
                {
                    'data': 'note',
                },
                {
                    'data': 'impact',
                },
                {
                    'data': 'category_impact',
                    "render": function(data, type, row, meta) {
                        if (row['category_impact'] && row['category_impact'].trim() !== "") { // Check if not null or empty
                            if (row['category_impact'].indexOf(',') > -1) { // Check if contains multiple impacts
                                let array_impact = row['category_impact'].split(','); // Split into an array
                                let badge_impact = '';
                                for (let index = 0; index < array_impact.length; index++) {
                                    badge_impact += `<span class="badge bg-light-orange text-dark">${array_impact[index].trim()}</span> `;
                                }
                                return badge_impact;
                            } else {
                                // Single category impact
                                return `<span class="badge bg-light-orange text-dark">${row['category_impact'].trim()}</span>`;
                            }
                        } else {
                            // If null or empty, return empty string
                            return ``;
                        }
                    }
                },
                {
                    'data': 'attachment',
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/review_file/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                }

            ],
        });
    }

    function dt_list_detail(start, end) {
        $('#dt_list_detail').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "responsive": true,
            buttons: [{
                title: 'Data Review System PIC',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseurl2}/get_list_detail`,
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    'data': 'id_review',
                    "render": function(data, type, row, meta) {
                        return meta.row + 1
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'id_review',
                    'className': 'text-center'
                },
                {
                    'data': 'company',
                    'className': 'text-center'
                },
                {
                    'data': 'department',
                },
                {
                    'data': 'head_name',
                },
                {
                    'data': 'pic_name',
                },
                {
                    'data': 'deadline_pic',
                },
                {
                    'data': 'aplikasi',
                },
                {
                    "data": "link",
                    "render": function(data, type, row, meta) {
                        return `<a href="${data}" class="badge bg-primary" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>`
                    },
                    'className': 'text-left'
                },
                {
                    'data': 'menu',
                    "render": function(data, type, row, meta) {
                        const subMenu = [data, row['sub_menu'], row['sub_sub_menu'], row['sub_sub_sub_menu']]
                            .filter(item => item && item.trim() && item.trim().toLowerCase() !== 'null')
                            .join(' > ');
                        return `${subMenu}`;
                    }
                },
                {
                    'data': 'category_impact',
                    "render": function(data, type, row, meta) {
                        if (row['category_impact'] && row['category_impact'].trim() !== "") { // Check if not null or empty
                            if (row['category_impact'].indexOf(',') > -1) { // Check if contains multiple impacts
                                let array_impact = row['category_impact'].split(','); // Split into an array
                                let badge_impact = '';
                                for (let index = 0; index < array_impact.length; index++) {
                                    badge_impact += `<span class="badge bg-light-orange text-dark">${array_impact[index].trim()}</span> `;
                                }
                                return badge_impact;
                            } else {
                                // Single category impact
                                return `<span class="badge bg-light-orange text-dark">${row['category_impact'].trim()}</span>`;
                            }
                        } else {
                            // If null or empty, return empty string
                            return ``;
                        }
                    },
                },
                {
                    'data': 'impact',
                },
                {
                    'data': 'status',
                },
                {
                    'data': 'kepuasan_aplikasi',
                    "render": function(data, type, row, meta) {
                        if (data == null) {
                            return ``
                        } else {
                            stars = '';
                            for (let i = 0; i < data; i++) {
                                stars += `<span class = "stars-list">★</span>`;
                            }
                            return `<div class="stars-box">${stars}</div>`;
                        }
                    }
                },
                {
                    'data': 'kesesuaian_aplikasi',
                },
                {
                    'data': 'impact_system',
                },
                {
                    'data': 'kesesuaian_uiux',
                },
                {
                    'data': 'improve_ui',
                    'render': function(data, type, row) {
                        if (row['kesesuaian_uiux'] == "tidak sesuai") {
                            return data;
                        } else {
                            return "-"
                        }
                    }
                },
                {
                    'data': 'improve_ux',
                    'render': function(data, type, row) {
                        if (row['kesesuaian_uiux'] == "tidak sesuai") {
                            return data;
                        } else {
                            return "-"
                        }
                    }
                },
                {
                    'data': 'note',
                },
                {
                    'data': 'improvement',
                },
                {
                    'data': 'attachment',
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/review_file/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                }

            ],
        });
    }

    function detail(id) {
        list_detail(id)
        $('#modal_detail').modal('show');
    }

    function dt_review_all(start, end) {

        $('#dt_review_all').DataTable({
            "searching": true,
            "info": true,
            "lengthChange": false,
            "paging": true,
            "destroy": true,
            "responsive": true,
            "order": [
                [0, 'desc']
            ],
            "dom": 'Bfrtip',
            buttons: [{
                title: 'Data Review System ' + start,
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseurl2}/get_data`,
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [

                {
                    'data': 'id_review',
                    // "render": function(data, type, row, meta) {
                    //     return `<a class="badge bg-info" href="javascript:void(0)" onclick="detail('${row['id_item']}')">${data}</a>`
                    // },
                    'className': 'text-center'
                },
                {
                    'data': 'company',
                },
                {
                    'data': 'department',
                },
                {
                    'data': 'head_name',
                },
                {
                    'data': 'pic_name',
                },
                {
                    'data': 'aplikasi',
                    'className': 'text-uppercase font-weight-bold'
                },
                {
                    'data': 'navigation',
                },
                {
                    'data': 'deadline_head',
                },
                {
                    'data': 'created_at',
                },
                {
                    'data': 'created_name',
                },
                {
                    'data': 'head_at',
                },
                {
                    'data': 'deadline_pic',
                }

            ],
        });
    }

    function input_review() {

        setDates()
        $('#modal_input').modal('show');
        url = `${baseurl2}/get_company`;
        $.getJSON(url, function(result) {
            res = '<option data-placeholder="true" value="#">-- Pilih Company --</option>';

            $.each(result, function(index, value) {
                res +=
                    `<option value="${value['company_id']}" >${value['company_name']}</option>`;
            })
            $("#company").empty().html(res);
            slim_company = new SlimSelect({
                select: "#company",
                settings: {
                    allowDeselect: true
                }
            });
        });

        url2 = `${baseurl2}/get_aplikasi`;
        $.getJSON(url2, function(result) {
            res = '<option data-placeholder="true" value="#">-- Pilih Aplikasi --</option>';

            $.each(result, function(index, value) {
                res +=
                    `<option value="${value['id']}" >${value['aplikasi']}</option>`;
            })
            $("#aplikasi").empty().html(res);
            slim_aplikasi = new SlimSelect({
                select: "#aplikasi",
                settings: {
                    allowDeselect: true
                }
            });
        });


        list_temp()
    }

    function list_temp() {
        $('#dt_list_nav_temp').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc']
            ],
            buttons: [{
                title: 'List Navigation',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseurl2}/get_navigation_temp`

            },
            "columns": [{
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1 +
                            `<input type="hidden" name="id_navigation[]" value="` + row['id_navigation'] + `" >
                        <input type="hidden" name="attachment[]" value="` + row['attachment'] + `" >`;
                    },
                    'className': 'text-center'
                },
                {
                    "data": "aplikasi",
                    'className': 'text-uppercase font-weight-bold'
                },
                {
                    "data": "link",
                    "render": function(data, type, row, meta) {
                        return `<a href="${data}" class="badge bg-primary" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>`
                    },
                    'className': 'text-left'
                },
                {
                    "data": "menu"
                },
                {
                    "data": "sub_menu",
                    "render": function(data, type, row, meta) {
                        const subMenu = [data, row['sub_sub_menu'], row['sub_sub_sub_menu']]
                            .filter(item => item && item.trim() && item.trim().toLowerCase() !== 'null')
                            .join(' > ');
                        return `${subMenu}`;
                    },
                    "className": "text-right"
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return `<a href="javascript:void(0)" title="Hapus" onclick="hapus_temp(${data})"><i class="bi bi-trash"></i></a>`
                    },
                    'className': 'text-center'
                }
            ]
        });

        //Check jumlah temp
        $.ajax({
            'url': `${baseurl2}/jumlah_temp`,
            'type': 'GET',
            'dataType': 'json',
            'success': function(response) {
                if (response[0].jumlah > 0) {
                    $('#btn_save_review').removeAttr('hidden');
                } else {
                    $('#btn_save_review').attr('hidden', true);
                }
            }
        })
    }

    let slim_department
    $('#company').change(function(e) {
        e.preventDefault();

        if (slim_department) {
            slim_department.destroy();
        }


        slim_department = new SlimSelect({
            select: "#department",
            allowDeselect: true,
            placeholder: '-- Pilih Department --',
        });

        const companyId = $(this).val();
        const url = `${baseurl2}/get_department/${companyId}`;


        $.getJSON(url, function(result) {

            const departmentData = result.map(value => ({
                text: value['department_name'],
                value: value['department_id']
            }));


            slim_department.setData([{
                    placeholder: true,
                    text: '-- Pilih Department --',
                    value: ''
                },
                ...departmentData
            ]);
        });
    });


    let slim_head
    $('#department').change(function(e) {
        e.preventDefault();

        if (slim_head) {
            slim_head.destroy();
        }


        slim_head = new SlimSelect({
            select: "#head",
            allowDeselect: true,
            placeholder: '-- Pilih Head --',
        });

        const departmentId = $(this).val();
        if (departmentId == '' || departmentId == null) {
            console.log(departmentId);
        } else {
            const url = `${baseurl2}/get_head/${departmentId}`;
            $.getJSON(url, function(result) {

                const headData = result.map(value => ({
                    text: `${value['nama_karyawan']} | ${value['designation_name']}`,
                    value: value['user_id']
                }));


                slim_head.setData([{
                        placeholder: true,
                        text: '-- Pilih Head --',
                        value: ''
                    },
                    ...headData
                ]);


                // $('#head_name').val(result[0]['nama_karyawan']);
                // $('#head').val(result[0]['user_id']);
            });
        }
    });

    //  List Navigation Old
    //  function listNavigation() {
    //      aplikasi = $('#aplikasi').val();
    //      if (aplikasi == "#") {
    //          $.confirm({
    //              icon: 'fa fa-times-circle',
    //              title: 'Warning',
    //              theme: 'material',
    //              type: 'red',
    //              content: 'Aplikasi belum dipilih!',
    //              buttons: {
    //                  close: {
    //                      actions: function() {}
    //                  },
    //              },
    //          });
    //      } else {

    //          $('#modal_list').modal('show');
    //          const id = $("#aplikasi option:selected").val();
    //          $('#dt_list_nav').DataTable({
    //              "searching": true,
    //              "info": true,
    //              "paging": true,
    //              "destroy": true,
    //              "dom": 'Bfrtip',
    //              "order": [
    //                  [0, 'asc']
    //              ],
    //              buttons: [{
    //                  title: 'List Navigation',
    //                  extend: 'excelHtml5',
    //                  text: 'Export to Excel',
    //                  footer: true
    //              }],
    //              "ajax": {
    //                  "dataType": 'json',
    //                  "type": "POST",
    //                  "url": `${baseurl2}/get_navigation/${id}`

    //              },
    //              "columns": [{
    //                      "data": "id",
    //                      "render": function(data, type, row, meta) {
    //                          return meta.row + 1
    //                      },
    //                      'className': 'text-center'
    //                  },
    //                  {
    //                      "data": "aplikasi",
    //                      'className': 'text-uppercase font-weight-bold'
    //                  },
    //                  {
    //                      "data": "link",
    //                      "render": function(data, type, row, meta) {
    //                          return `<a href="${data}" class="badge bg-primary" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>`
    //                      },
    //                      'className': 'text-left'
    //                  },
    //                  {
    //                      "data": "menu",
    //                      "render": function(data, type, row) {
    //                          if (data == null) {
    //                              return '';
    //                          } else {
    //                              return `<a class="badge bg-success" href="javascript:void(0)" onclick="tambah_nav('` + row['aplikasi'] + `', '` + row['id'] + `', '` + row['menu'] + `', '` + row['sub_menu'] + `', '` + row['sub_sub_menu'] + `', '` + row['sub_sub_sub_menu'] + `')">` + data + `</a>`;
    //                          }
    //                      },
    //                      "className": "text-right"
    //                  },
    //                  {
    //                      "data": "sub_menu",
    //                      "render": function(data, type, row, meta) {
    //                          if (row['sub_sub_sub_menu'] != null) {
    //                              return `${data} > ${row['sub_sub_menu']} > ${row['sub_sub_sub_menu']}`
    //                          } else if (row['sub_sub_menu'] != null) {
    //                              return `${data} > ${row['sub_sub_menu']}`
    //                          } else {
    //                              return `${data}`
    //                          }
    //                      }
    //                  },
    //                  {
    //                      "data": "deskripsi",
    //                      "className": "text-right"
    //                  }
    //              ],
    //          });

    //      }
    //  }

    function listNavigation() {
        let aplikasi = $('#aplikasi').val();

        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        if (aplikasi == "#") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Aplikasi belum dipilih!',
                buttons: {
                    close: {
                        actions: function() {}
                    }
                }
            });
            return;
        }

        $('#modal_list').modal('show');
        const id = $("#aplikasi option:selected").val();

        $('#dt_list_nav').DataTable({
            searching: true,
            info: true,
            paging: true,
            destroy: true,
            dom: 'Bfrtip',
            order: [
                [0, 'asc']
            ],
            buttons: [{
                title: 'List Navigation',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            ajax: {
                dataType: 'json',
                type: 'POST',
                url: `${baseurl2}/get_navigation/${id}`
            },
            columns: [{
                    data: "id",
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    className: 'text-center'
                },
                {
                    data: "aplikasi",
                    className: 'text-uppercase font-weight-bold'
                },
                {
                    data: "link",
                    render: function(data) {
                        return `<a href="${escapeHtml(data)}" class="badge bg-primary" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>`;
                    },
                    className: 'text-left'
                },
                {
                    data: "menu",
                    render: function(data, type, row) {
                        if (!data) return '';

                        const args = [
                            row['aplikasi'],
                            row['id'],
                            row['menu'],
                            row['sub_menu'],
                            row['sub_sub_menu'],
                            row['sub_sub_sub_menu']
                        ].map(v => JSON.stringify(v)).join(', ');

                        return `<a class="badge bg-success" href="javascript:void(0)" onclick='tambah_nav(${args})'>${escapeHtml(data)}</a>`;
                    },
                    className: "text-right"
                },
                {
                    data: "sub_menu",
                    render: function(data, type, row) {
                        if (row['sub_sub_sub_menu'] != null) {
                            return `${data} > ${row['sub_sub_menu']} > ${row['sub_sub_sub_menu']}`;
                        } else if (row['sub_sub_menu'] != null) {
                            return `${data} > ${row['sub_sub_menu']}`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    data: "deskripsi",
                    className: "text-right"
                }
            ]
        });
    }

    function tambah_nav(aplikasi, id_navigation, menu, sub_menu, sub_sub_menu, sub_sub_sub_menu) {
        const subMenu = [sub_menu, sub_sub_menu, sub_sub_sub_menu]
            .filter(item => item && item.trim() && item.trim().toLowerCase() !== 'null')
            .join(' > ');
        $('#modal_add_temp').modal('show');
        $('#modal_list').modal('hide');
        $('#apl').val(aplikasi);
        $('#id_navigation').val(id_navigation);
        $('#menu').val(menu);
        $('#sub_menu').val(subMenu);
    }

    function save_temp() {
        const form = $('#form_add_temp')[0];
        const formData = new FormData(form);

        $.ajax({
            url: `${baseurl2}/simpan_temp`,
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("#btn_save_temp").html('Please wait...');
                $("#btn_save_temp").prop('disabled', true);
            },
            success: function(response) {
                list_temp()
                $('#form_add_temp')[0].reset();
                $('#modal_add_temp').modal('hide');
            },
            complete: function() {
                $("#btn_save_temp").html('Save');
                $("#btn_save_temp").prop('disabled', false);
            },
            error: function(err) {
                alert('Terjadi kesalahan: ' + JSON.stringify(err));
            }
        });
    }

    function hapus_temp(id) {
        $.ajax({
            url: `${baseurl2}/hapus_temp`,
            type: 'POST',
            dataType: 'json',
            data: {
                id
            },
            success: function(response) {
                list_temp()
            },
            error: function(err) {
                alert('Terjadi kesalahan: ' + JSON.stringify(err));
            }
        });
    }

    // save review sistem
    function save_review() {
        company = $("#company").val()
        department = $("#department").val()
        head = $("#head").val()
        aplikasi = $("#aplikasi").val()
        deadline_head = $("#deadline_head").val()
        console.log(`cek value :  company:${company} - department:${department} - head:${head} - aplikasi:${aplikasi} - deadline_head:${deadline_head}`)

        if (company == "#") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Company belum dipilih!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (department == "#") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Department belum dipilih!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (head == "#") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Head belum dipilih!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (aplikasi == "#") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Aplikasi belum dipilih!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (deadline_head == "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Deadline belum terisi!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
            const form = $('#form_add_review')[0];
            const formData = new FormData(form);
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {
                    $.ajax({
                        method: "POST",
                        url: `${baseurl2}/simpan_review`,
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        beforeSend: function(res) {
                            $("#btn_save_review").html('Please wait...');
                            $("#btn_save_review").prop('disabled', true);
                        },
                        success: function(res) {
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
                            $('#form_add_review')[0].reset();
                            $('#modal_input').modal('hide');
                            dt_review_all('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
                            jconfirm.instances[0].close();
                        },
                        complete: function() {
                            $("#btn_save_review").html('Save');
                            $("#btn_save_review").prop('disabled', false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            jconfirm.instances[0].close();
                        }
                    });
                }
            });
        }


    }

    function list_review_head() {
        $('#dt_list_review_head').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc']
            ],
            buttons: [{
                title: 'List Review Head',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "GET",
                "url": `${baseurl2}/list_review_head`

            },
            "columns": [{
                    "data": "id_review",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1
                    },
                    'className': 'text-center'
                },
                {
                    "data": "id_review",
                    "render": function(data, type, row, meta) {
                        if (row['head_at'] == null) {
                            return `<a class="badge bg-danger" href="javascript:void(0)" onclick="add_pic('${data}','${row['head_name']}','${row['deadline_head']}','${row['department_id']}')">${data}</a>`
                        } else {
                            return `<span class="badge bg-success" >${data}</span>`
                        }
                    },
                    'className': 'text-center'
                },
                {
                    "data": "company",
                    'className': 'text-center'
                },
                {
                    "data": "department",
                    'className': 'text-center'
                },
                {
                    "data": "head_name",
                    'className': 'text-center'
                },
                {
                    "data": "deadline_head",
                    'className': 'text-center'
                }
            ]
        });
    }

    function review_head() {
        $('#modal_list_head').modal('show');
        list_review_head()
    }

    function list_item_review_head(id) {
        // $.ajax({
        //     'url': `${baseurl2}/list_review_head_item/${id}`,
        //     'type': 'GET',
        //     'dataType': 'json',
        //     'success': function(response) {
        //         jumlah_data = response.data.length
        //         console.log(jumlah_data)
        //     }
        // })

        // $.ajax({
        //     'url': `${baseurl2}/jumlah_pic`,
        //     'type': 'POST',
        //     'dataType': 'json',
        //     'data': {
        //         'id': id
        //     },
        //     'success': function(response) {
        //         if (response[0].jumlah == jumlah_data) {
        //             $('#btn_save_head').removeAttr('hidden');
        //         } else {
        //             $('#btn_save_head').attr('hidden', true);
        //         }
        //     }
        // })

        $('#dt_list_item_review_head').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc']
            ],
            buttons: [{
                title: 'List Review Head',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "GET",
                "url": `${baseurl2}/list_review_head_item/${id}`
            },
            "columns": [{
                    "data": "id_review",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1
                    },
                    'className': 'text-center'
                },
                {
                    "data": "pic_name",
                    "render": function(data, type, row, meta) {
                        if (row['pic'] == null) {
                            const selectId = `pic_${row['id_item']}`; // Unique ID for each row

                            // Generate select input
                            const selectHtml = `
                            <select name="pic" id="${selectId}" class="form-control border-custom"></select>
                        `;

                            // Populate select options dynamically
                            setTimeout(() => {
                                const url = `${baseurl2}/get_pic/${row['department_id']}`;
                                $.getJSON(url, function(result) {
                                    let res = '<option data-placeholder="true" value="#" disabled selected>-- Pilih PIC --</option>';
                                    $.each(result, function(index, value) {
                                        res += `<option value="${value['user_id']}">${value['nama_karyawan']} | ${value['designation_name']}</option>`;
                                    });
                                    $(`#${selectId}`).empty().html(res);
                                    new SlimSelect({
                                        select: `#${selectId}`
                                    });
                                });
                            }, 0);

                            return selectHtml;
                        } else {
                            return data;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'pic',
                    "render": function(data, type, row, meta) {
                        if (row['pic'] == null) {
                            const selectId = `deadline_${row['id_item']}`
                            return `<select name="deadline_pic" id="${selectId}" class="form-control border-custom">
                                    <option value="#" disabled>-- Pilih Deadline --</option>
                                    <option value="1">1 hari</option>
                                    <option value="2">2 hari</option>
                                    <option value="3">3 hari</option>
                                    <option value="4">4 hari</option>
                                    <option value="5">5 hari</option>
                                </select>`
                        } else {
                            return data;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    "data": "aplikasi",
                    'className': 'text-uppercase font-weight-bold text-center'
                },
                {
                    "data": "link",
                    "render": function(data, type, row, meta) {
                        return `<a href="${data}" class="badge bg-primary" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>`
                    },
                    'className': 'text-center'
                },
                {
                    "data": "menu",
                    'className': 'text-center'
                },
                {
                    "data": "sub_menu",
                    "render": function(data, type, row, meta) {
                        const subMenu = [data, row['sub_sub_menu'], row['sub_sub_sub_menu']]
                            .filter(item => item && item.trim() && item.trim().toLowerCase() !== 'null')
                            .join(' > ');
                        return `${subMenu}`;
                    }
                },
                {
                    "data": "attachment",
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/review_file/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                }
            ]
        });
    }


    function add_pic(id, head, deadline, department_id) {

        list_item_review_head(id)
        $('#id_review').val(id);
        $('#head_pic').val(head);
        $('#deadline_h').val(deadline);
        $('#modal_add_pic').modal('show');
    }

    // let slim_deadline
    // let slim_pic

    // function add_form_pic(id, aplikasi, menu, department_id) {
    //     $('#id_item').val(id);
    //     $('#apl_pic').val(aplikasi);
    //     $('#menu_pic').val(menu);

    //     if (slim_deadline) {
    //         slim_deadline.destroy();
    //     }
    //     if (slim_pic) {
    //         slim_pic.destroy();
    //     }
    //     slim_deadline = new SlimSelect({
    //         select: "#deadline_pic",
    //         settings: {
    //             allowDeselect: true
    //         }
    //     });
    //     url = `${baseurl2}/get_pic/${department_id}`;
    //     $.getJSON(url, function(result) {
    //         res = '<option data-placeholder="true" value="#" disable>-- Pilih PIC --</option>';

    //         $.each(result, function(index, value) {
    //             res +=
    //                 `<option value="${value['user_id']}" >${value['nama_karyawan']} | ${value['designation_name']}</option>`;
    //         })
    //         $("#pic").empty().html(res);
    //         slim_pic = new SlimSelect({
    //             select: "#pic",
    //             settings: {
    //                 allowDeselect: true
    //             }
    //         });
    //     });
    //     $('#modal_form_pic').modal('show');
    // }

    // function save_pic() {
    //     const id_review = $('#id_review').val();
    //     const id_item = $('#id_item').val();
    //     const pic = $('#pic').val();
    //     const deadline_pic = $('#deadline_pic').val();


    //     if (pic == "#") {
    //         $.confirm({
    //             icon: 'fa fa-times-circle',
    //             title: 'Warning',
    //             theme: 'material',
    //             type: 'red',
    //             content: 'PIC belum dipilih!',
    //             buttons: {
    //                 close: {
    //                     action: function() {}
    //                 },
    //             },
    //         });
    //     } else if (deadline_pic == null) {
    //         $.confirm({
    //             icon: 'fa fa-times-circle',
    //             title: 'Warning',
    //             theme: 'material',
    //             type: 'red',
    //             content: 'Deadline belum dipilih!',
    //             buttons: {
    //                 close: {
    //                     action: function() {}
    //                 },
    //             },
    //         });
    //     } else {
    //         const form = $('#form_add_pic')[0];
    //         const formData = new FormData(form); // Proper handling for file uploads
    //         $.confirm({
    //             icon: 'fa fa-spinner fa-spin',
    //             title: 'Please wait!',
    //             theme: 'material',
    //             type: 'blue',
    //             content: 'Processing...',
    //             buttons: {
    //                 close: {
    //                     isHidden: true,
    //                     actions: function() {}
    //                 },
    //             },
    //             onOpen: function() {
    //                 $.ajax({
    //                     method: "POST",
    //                     url: `${baseurl2}/simpan_pic`,
    //                     dataType: "JSON",
    //                     cache: false,
    //                     contentType: false,
    //                     processData: false,
    //                     data: formData,
    //                     beforeSend: function(res) {
    //                         $("#btn_save_pic").html('Please wait...');
    //                         $("#btn_save_pic").prop('disabled', true);
    //                     },
    //                     success: function(res) {
    //                         $.confirm({
    //                             icon: 'fa fa-check',
    //                             title: 'Success',
    //                             theme: 'material',
    //                             type: 'green',
    //                             content: 'Data has been saved!',
    //                             buttons: {
    //                                 close: {
    //                                     actions: function() {}
    //                                 },
    //                             },
    //                         });
    //                         $('#form_add_pic')[0].reset();
    //                         $('#modal_form_pic').modal('hide');
    //                         list_item_review_head(id_review)
    //                         jconfirm.instances[0].close();
    //                     },
    //                     complete: function() {
    //                         $("#btn_save_pic").html('Save');
    //                         $("#btn_save_pic").prop('disabled', false);
    //                     },
    //                     error: function(jqXHR, textStatus, errorThrown) {
    //                         console.log(jqXHR.responseText);
    //                         jconfirm.instances[0].close();
    //                     }
    //                 });
    //             }
    //         });
    //     }
    // }

    function dt_list_pic() {
        $('#dt_list_pic').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc']
            ],
            buttons: [{
                title: 'List Review PIC',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "GET",
                "url": `${baseurl2}/get_list_pic`
            },
            "columns": [{
                    "data": "id_review",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1
                    },
                    'className': 'text-center'
                },
                {
                    "data": "id_review",
                    "render": function(data, type, row, meta) {
                        const subMenu = [row['sub_menu'], row['sub_sub_menu'], row['sub_sub_sub_menu']]
                            .filter(item => item && item.trim() && item.trim().toLowerCase() !== 'null')
                            .join(' > ');
                        return `<a class="badge bg-info" href="javascript:void(0)" onclick="add_pic_check('${data}','${row['id_item']}','${row['aplikasi']}','${row['menu']}','${subMenu}')">${data}</a>`

                    },
                    'className': 'text-center'
                },
                {
                    "data": "pic_name",
                    'className': 'text-center'
                },
                {
                    "data": "deadline_pic",
                    'className': 'text-center'
                },
                {
                    "data": "aplikasi",
                    'className': 'text-uppercase font-weight-bold text-center'
                },
                {
                    "data": "link",
                    "render": function(data, type, row, meta) {
                        return `<a href="${data}" class="badge bg-primary" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>`
                    },
                    'className': 'text-center'
                },
                {
                    "data": "menu",
                    "render": function(data, type, row, meta) {
                        const subMenu = [data, row['sub_menu'], row['sub_sub_menu'], row['sub_sub_sub_menu']]
                            .filter(item => item && item.trim() && item.trim().toLowerCase() !== 'null')
                            .join(' > ');
                        return `${subMenu}`;
                    },
                    'className': 'text-center'
                },
                {
                    "data": "attachment",
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/review_file/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                }
            ]
        });
    }

    // function save_review_head() {
    //     const form = $('#form_add_head')[0];
    //     const formData = new FormData(form); // Proper handling for file uploads
    //     $.confirm({
    //         icon: 'fa fa-spinner fa-spin',
    //         title: 'Please wait!',
    //         theme: 'material',
    //         type: 'blue',
    //         content: 'Processing...',
    //         buttons: {
    //             close: {
    //                 isHidden: true,
    //                 actions: function() {}
    //             },
    //         },
    //         onOpen: function() {
    //             $.ajax({
    //                 method: "POST",
    //                 url: `${baseurl2}/simpan_head`,
    //                 dataType: "JSON",
    //                 cache: false,
    //                 contentType: false,
    //                 processData: false,
    //                 data: formData,
    //                 beforeSend: function(res) {
    //                     $("#btn_save_head").html('Please wait...');
    //                     $("#btn_save_head").prop('disabled', true);
    //                 },
    //                 success: function(res) {
    //                     $.confirm({
    //                         icon: 'fa fa-check',
    //                         title: 'Success',
    //                         theme: 'material',
    //                         type: 'green',
    //                         content: 'Data has been saved!',
    //                         buttons: {
    //                             close: {
    //                                 actions: function() {}
    //                             },
    //                         },
    //                     });
    //                     jconfirm.instances[0].close();
    //                 },
    //                 complete: function() {
    //                     $('#form_add_head')[0].reset();
    //                     $('#modal_add_pic').modal('hide');
    //                     list_review_head()
    //                     $("#btn_save_head").html('Save');
    //                     $("#btn_save_head").prop('disabled', false);
    //                 },
    //                 error: function(jqXHR, textStatus, errorThrown) {
    //                     console.log(jqXHR.responseText);
    //                     jconfirm.instances[0].close();
    //                 }
    //             });
    //         }
    //     });
    // }

    function save_review_head() {
        const tableRows = $('#dt_list_item_review_head').DataTable().rows().data().toArray();
        const picData = [];
        const id_review = $('#id_review').val()
        let isValid = true;

        tableRows.forEach(row => {
            const picId = `pic_${row.id_item}`;
            const deadlineId = `deadline_${row.id_item}`;
            const picValue = $(`#${picId}`).val();
            const deadlineValue = $(`#${deadlineId}`).val();

            // Validasi jika PIC atau Deadline kosong
            if (!picValue || picValue === "#" || !deadlineValue || deadlineValue === "#") {
                isValid = false;
            }

            // Tambahkan ke picData jika valid
            if (picValue && deadlineValue) {
                picData.push({
                    id_item: row.id_item,
                    pic: picValue,
                    deadline_pic: deadlineValue
                });
            }
        });

        if (!isValid) {
            $.alert({
                icon: 'fa fa-exclamation-triangle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Pastikan semua PIC dan Deadline PIC telah diisi!',
            });
            return;
        }

        const formData = new FormData();
        formData.append('id_review', id_review);
        formData.append('pic_data', JSON.stringify(picData));

        $.ajax({
            method: "POST",
            url: `${baseurl2}/simpan_head`,
            dataType: "JSON",
            contentType: false, // FormData tidak memerlukan ini
            processData: false, // Jangan proses data
            data: formData,
            beforeSend: function() {
                $("#btn_save_head").html('Please wait...');
                $("#btn_save_head").prop('disabled', true);
            },
            success: function(res) {
                if (res.status === 'success') {
                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Success',
                        theme: 'material',
                        type: 'green',
                        content: res.message,
                        buttons: {
                            close: function() {}
                        }
                    });
                    $('#modal_add_pic').modal('hide');
                    list_review_head()
                } else {
                    $.alert({
                        icon: 'fa fa-exclamation-triangle',
                        title: 'Error',
                        theme: 'material',
                        type: 'red',
                        content: res.message
                    });
                }
            },
            complete: function() {
                $("#btn_save_head").html('Save');
                $("#btn_save_head").prop('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(jqXHR.responseText);
            }
        });
    }



    function pic_check() {
        $('#modal_list_pic').modal('show');
        dt_list_pic()
    }

    function add_pic_check(id_review, id_item, aplikasi, menu, submenu) {
        $('#id_review_check').val(id_review);
        $('#id_item_check').val(id_item);
        $('#aplikasi_check').val(aplikasi);
        $('#menu_check').val(menu);
        $('#sub_menu_check').val(submenu);
        $('#modal_input_check_pic').modal('show');

        url = `${baseurl2}/get_status`;
        $.getJSON(url, function(result) {
            res = '<option data-placeholder="true" value="#">-- Pilih Status --</option>';

            $.each(result, function(index, value) {
                res +=
                    `<option value="${value['id']}" >${value['status']}</option>`;
            })
            $("#status").empty().html(res);
            slim_status = new SlimSelect({
                select: "#status",
                settings: {
                    allowDeselect: true
                }
            });
        });

        url2 = `${baseurl2}/get_sesuai`;
        $.getJSON(url2, function(result) {
            res = '<option data-placeholder="true" value="#">-- Pilih Kesesuaian --</option>';

            $.each(result, function(index, value) {
                res +=
                    `<option value="${value['status']}" >${value['status']}</option>`;
            })
            $("#kesesuaian_aplikasi").empty().html(res);
            slim_kesesuaian_aplikasi = new SlimSelect({
                select: "#kesesuaian_aplikasi",
                settings: {
                    allowDeselect: true
                }
            });
        });

        url3 = `${baseurl2}/get_impact_category`;
        $.getJSON(url3, function(result) {
            res = '<option data-placeholder="true" value="#">-- Pilih Category Impact --</option>';

            $.each(result, function(index, value) {
                res +=
                    `<option value="${value['id']}" >${value['impact']}</option>`;
            })
            $("#impact_category").empty().html(res);
            slim_impact_category = new SlimSelect({
                select: "#impact_category",
                settings: {
                    allowDeselect: true
                }
            });
        });
    }

    function save_check_pic() {
        let id_review = $('#id_review_check').val();
        let id_item = $('#id_item_check').val();
        let aplikasi = $('#aplikasi_check').val();
        let menu = $('#menu_check').val();
        let status = $('#status').val();
        let kesesuaian_aplikasi = $('#kesesuaian_aplikasi').val();
        let impact_category = $('#impact_category').val();
        let impact = $('#impact').val();
        let improvement = $('#improvement').val();
        let kepuasan_aplikasi = $('input[name="kepuasan_aplikasi"]:checked').val()
        let status_sistem = $('#status_sistem').val();
        let kesesuaian_uiux = $('#kesesuaian_uiux').val();
        let ui = $('#ui').val();
        let ux = $('#ux').val();

        console.log(`status : ${status} - kesesuaian : ${kesesuaian_aplikasi} - impact_category : ${impact_category} - impact : ${impact} - kepuasan: ${kepuasan_aplikasi}`)

        console.log(`status_sistem : ${status_sistem} - kesesuaian_uiux : ${kesesuaian_uiux} - ui : ${ui.length} - ux : ${ux.length}`)

        if (status == "#") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Status belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (kesesuaian_aplikasi == '#') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Kesesuain Request Fitur belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (impact_category == '') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Impact Category belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (kepuasan_aplikasi == undefined) {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Kepuasan Fitur belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (status_sistem == '#') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Status Sistem belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (kesesuaian_uiux == '#') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Kesesuaian UI/UX belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (kesesuaian_uiux == 'Tidak Sesuai' && ui.length == 57) {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Improve UI belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (kesesuaian_uiux == 'Tidak Sesuai' && ux.length == 74) {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Improve UX belum dipilih!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (impact == '') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Impact belum terisi!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else if (improvement == '') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'improvement belum terisi!',
                buttons: {
                    close: {
                        action: function() {}
                    },
                },
            });
        } else {
            const form = $('#form_check_pic')[0];
            const formData = new FormData(form); // Proper handling for file uploads
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {
                    $.ajax({
                        method: "POST",
                        url: `${baseurl2}/simpan_pic_check`,
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        beforeSend: function(res) {
                            $("#btn_save_check_pic").html('Please wait...');
                            $("#btn_save_check_pic").prop('disabled', true);
                        },
                        success: function(res) {
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
                            $('#form_check_pic')[0].reset();
                            $('#modal_input_check_pic').modal('hide');
                            dt_list_pic()
                            jconfirm.instances[0].close();
                        },
                        complete: function() {
                            $("#btn_save_check_pic").html('Save');
                            $("#btn_save_check_pic").prop('disabled', false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            jconfirm.instances[0].close();
                        }
                    });
                }
            });
        }
    }
</script>