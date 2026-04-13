<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
<!-- Select2 plugin -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"> -->
<!-- Select2 plugin -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->



<script>
    $(document).ready(function() {

        function hideSearchInputs(columns) {
            for (i = 0; i < columns.length; i++) {
                if (columns[i]) {
                    $(".filters th:eq(" + i + ")").show();
                } else {
                    $(".filters th:eq(" + i + ")").hide();
                }
            }
        }


        // $('#dt_trusmi_history thead tr').clone(true).addClass('filters').appendTo('#dt_trusmi_history thead');
        var table = $('#dt_trusmi_history').DataTable({});
        table.on("responsive-resize", function(e, datatable, columns) {
            hideSearchInputs(columns);
        });

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dt_trusmi_history(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            dt_search(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });


    function slim(selectId, placeholderText) {
        new SlimSelect({
            select: selectId,
            settings: {
                placeholderText: placeholderText,
            }
        });
    }



    function hideSearchInputs(columns) {
        for (i = 0; i < columns.length; i++) {
            if (columns[i]) {
                $(".filters th:eq(" + i + ")").show();
            } else {
                $(".filters th:eq(" + i + ")").hide();
            }
        }
    }



    function dt_trusmi_history(start, end) {
        var table = $('#dt_trusmi_history').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            // responsive: {
            //     details: {
            //         display: $.fn.dataTable.Responsive.display.modal({
            //             header: function(row) {
            //                 var data = row.data();
            //                 return 'Details for ' + data[0] + ' ' + data[1];
            //             }
            //         }),
            //         renderer: $.fn.dataTable.Responsive.renderer.tableAll()
            //     }
            // },
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>trusmi_history/dt_trusmi_history",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    "data": "tanggal",
                },
                {
                    "data": "employee_name",
                },
                {
                    "data": "perusahaan",
                },
                {
                    "data": "department",
                },
                // {
                //     "data": "designation_name",
                // },
                {
                    "data": "status_lock",
                },
                {
                    "data": "reason",
                    "width": "20%"
                },
                {
                    "data": "attempp",
                    "className": "text-center"
                },
                {
                    "data": "clock_out",
                },
            ],
            // initComplete: function() {
            //     count = 0;
            //     this.api().columns().every(function() {
            //         var title;
            //         title = this.header();
            //         //replace spaces with dashes
            //         title = $(title).html().replace(/[\W]/g, '-');
            //         var column = this;
            //         var select = $('<select id="' + title + '" class="select2 filters" ></select>')
            //             .appendTo($(column.header()).empty())
            //             .on('change', function() {
            //                 //Get the "text" property from each selected data 
            //                 //regex escape the value and store in array
            //                 var data = $.map($(this).select2('data'), function(value, key) {
            //                     return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
            //                 });

            //                 //if no data selected use ""
            //                 if (data.length === 0) {
            //                     data = [""];
            //                 }

            //                 //join array into string with regex or (|)
            //                 var val = data.join('|');

            //                 //search for the option(s) selected
            //                 column
            //                     .search(val ? val : '', true, false)
            //                     .draw();
            //             });

            //         column.data().unique().sort().each(function(d, j) {
            //             select.append('<option value="' + d + '">' + d + '</option>');
            //         });

            //         //use column title as selector and placeholder
            //         $('#' + title).select2({
            //             multiple: true,
            //             closeOnSelect: false,
            //             // placeholder: " Search " + title
            //         });

            //         //initially clear select otherwise first option is selected
            //         $('.select2').val(null).trigger('change');
            //     });


            // }

            // initComplete: function() {
            //     this.api()
            //         .columns()
            //         .every(function() {
            //             var column = this;
            //             var select = $('<select class="slim_select" multiple><option data-placeholder="true"></option></select>')
            //                 .appendTo($(column.footer()).empty())
            //                 .on('change', function() {
            //                     var val = $.fn.dataTable.util.escapeRegex($(this).val());

            //                     column.search(val ? '^' + val + '$' : '', true, false).draw();
            //                 });

            //             column
            //                 .data()
            //                 .unique()
            //                 .sort()
            //                 .each(function(d, j) {
            //                     select.append('<option value="' + d + '">' + d + '</option>');
            //                 });
            //         });

            //     $(".slim_select").each((i, e) => {
            //         new SlimSelect({
            //             select: e,
            //             settings: {
            //                 placeholderText: 'search',
            //             }
            //         })
            //     });
            // },
            // initComplete: function() {
            //     var api = this.api();

            //     // For each column
            //     api
            //         .columns()
            //         .eq(0)
            //         .each(function(colIdx) {
            //             // Set the header cell to contain the input element
            //             var cell = $('.filters th').eq(
            //                 $(api.column(colIdx).header()).index()
            //             );
            //             var title = $(cell).text();
            //             $(cell).html('<input type="text" placeholder="' + title + '" />');

            //             // On every keypress in this input
            //             $(
            //                     'input',
            //                     $('.filters th').eq($(api.column(colIdx).header()).index())
            //                 )
            //                 .off('keyup change')
            //                 .on('change', function(e) {
            //                     // Get the search value
            //                     $(this).attr('title', $(this).val());
            //                     var regexr = '({search})'; //$(this).parents('th').find('select').val();

            //                     var cursorPosition = this.selectionStart;
            //                     // Search the column for that value
            //                     api
            //                         .column(colIdx)
            //                         .search(
            //                             this.value != '' ?
            //                             regexr.replace('{search}', '(((' + this.value + ')))') :
            //                             '',
            //                             this.value != '',
            //                             this.value == ''
            //                         )
            //                         .draw();
            //                 })
            //                 .on('keyup', function(e) {
            //                     e.stopPropagation();

            //                     $(this).trigger('change');
            //                     $(this)
            //                         .focus()[0]
            //                         .setSelectionRange(cursorPosition, cursorPosition);
            //                 });
            //         });
            // },
        });
    }

    let searchNama = new SlimSelect({
        select: '#search-nama',
        settings: {
            placeholderText: 'nama',
        }
    });
    let searchTanggal = new SlimSelect({
        select: '#search-tanggal',
        settings: {
            placeholderText: 'tanggal',
        }
    });
    let searchPerusahaan = new SlimSelect({
        select: '#search-perusahaan',
        settings: {
            placeholderText: 'perusahaan',
        }
    });
    let searchDepartment = new SlimSelect({
        select: '#search-department',
        settings: {
            placeholderText: 'department',
        }
    });
    let searchTypeLock = new SlimSelect({
        select: '#search-type-lock',
        settings: {
            placeholderText: 'type-lock',
        }
    });

    function dt_search(start, end) {
        table = $('#dt_trusmi_history').DataTable();
        $.ajax({
            url: '<?= base_url(); ?>trusmi_history/dt_trusmi_history',
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
            },
            beforeSend: function() {
                searchNama.setData();
                searchPerusahaan.setData();
                searchDepartment.setData();
                searchTypeLock.setData();
            },
            success: function(response) {
                // ---------------------------------------------------------------------------------------
                array_tanggal = [];
                array_employee_name = [];
                array_perusahaan = [];
                array_department = [];
                array_type_lock = [];
                for (let index = 0; index < response.data.length; index++) {
                    if (array_tanggal.indexOf(response.data[index].tanggal) === -1) {
                        array_tanggal.push(response.data[index].tanggal);
                    }
                    if (array_employee_name.indexOf(response.data[index].employee_name) === -1) {
                        array_employee_name.push(response.data[index].employee_name);
                    }
                    if (array_perusahaan.indexOf(response.data[index].perusahaan) === -1) {
                        array_perusahaan.push(response.data[index].perusahaan);
                    }
                    if (array_department.indexOf(response.data[index].department) === -1) {
                        array_department.push(response.data[index].department);
                    }
                    if (array_type_lock.indexOf(response.data[index].status_lock) === -1) {
                        array_type_lock.push(response.data[index].status_lock);
                    }
                }
                // ------
                itemTanggal = [];
                for (let index = 0; index < array_tanggal.length; index++) {
                    itemTanggal.push({
                        text: array_tanggal[index],
                        value: array_tanggal[index]
                    });
                }
                searchTanggal.setData(itemTanggal);

                $('#search-tanggal').on('change', function() {
                    rangeTanggal = searchTanggal.getSelected().toString().replaceAll(",", "|");;
                    table.column(0).search(rangeTanggal, true, false).draw();
                });
                // ------
                itemEmployeArr = [];
                for (let index = 0; index < array_employee_name.length; index++) {
                    itemEmployeArr.push({
                        text: array_employee_name[index],
                        value: array_employee_name[index]
                    });
                }
                searchNama.setData(itemEmployeArr);

                $('#search-nama').on('change', function() {
                    rangeNama = searchNama.getSelected().toString().replaceAll(",", "|");
                    table.column(1).search(rangeNama, true, false).draw();
                });
                // ------
                itemPerusahaan = [];
                for (let index = 0; index < array_perusahaan.length; index++) {
                    itemPerusahaan.push({
                        text: array_perusahaan[index],
                        value: array_perusahaan[index]
                    });
                }
                searchPerusahaan.setData(itemPerusahaan);

                $('#search-perusahaan').on('change', function() {
                    rangePerushaan = searchPerusahaan.getSelected().toString().replaceAll(",", "|");
                    table.column(2).search(rangePerushaan, true, false).draw();
                });

                // ------
                itemDepartment = [];
                for (let index = 0; index < array_department.length; index++) {
                    itemDepartment.push({
                        text: array_department[index],
                        value: array_department[index]
                    });
                }
                searchDepartment.setData(itemDepartment);

                $('#search-department').on('change', function() {
                    rangeDepartment = searchDepartment.getSelected().toString().replaceAll(",", "|");
                    table.column(3).search(rangeDepartment, true, false).draw();
                });
                // ------
                itemTypeLock = [];
                for (let index = 0; index < array_type_lock.length; index++) {
                    itemTypeLock.push({
                        text: array_type_lock[index],
                        value: array_type_lock[index]
                    });
                }
                searchTypeLock.setData(itemTypeLock);
                $('#search-type-lock').on('change', function() {
                    rangeTypeLock = searchTypeLock.getSelected().toString().replaceAll(",", "|");
                    table.column(4).search(rangeTypeLock, true, false).draw();
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }
</script>