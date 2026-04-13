 <script src="<?= base_url(); ?>assets/gantt/codebase/dhtmlxgantt.js"></script>
 <link rel="stylesheet" href="<?= base_url(); ?>assets/gantt/codebase/dhtmlxgantt.css">

 <script>
     function dt_gantt() {
         start = $('#start').val();
         end = $('#end').val();
         filter_type = $('#filter_type').val();
         filter_pic = $('#filter_pic').val();
         filter_status = $('#filter_status').val();
         $.ajax({
             url: '<?= base_url(); ?>tickets/gantt/dt_gantt',
             type: 'POST',
             dataType: 'json',
             data: {
                 start: start,
                 end: end,
                 filter_type: filter_type,
                 filter_pic: filter_pic,
                 filter_status: filter_status.toString()
             },
             beforeSend: function() {
                 $('#div_gantt').empty().append('<div id="gantt_here" style="min-height: 500px;"></div>')
             },
             success: function(response) {

             },
             error: function(xhr) { // if error occured

             },
             complete: function() {

             },
         }).done(function(response) {
             console.log(response)
             let data_gantt = [];
             for (let index_type = 0; index_type < response.data_type.length; index_type++) {
                 data_gantt.push({
                     id: response.data_type[index_type].id_type,
                     task: response.data_type[index_type].type + '(' + response.data_type[index_type].jml_task + ')',
                     text: response.data_type[index_type].type + '(' + response.data_type[index_type].jml_task + ')',
                     id_status: response.data_type[index_type].id_status,
                     start_date: response.data_type[index_type].start_date,
                     end_date: response.data_type[index_type].end_date,
                     start_date_text: response.data_type[index_type].start_date_text,
                     end_date_text: response.data_type[index_type].end_date_text,
                     duration: response.data_type[index_type].duration,
                     pic: null,
                     progress: response.data_type[index_type].progress,
                     open: true
                 })
             }
             for (let index_sub_type = 0; index_sub_type < response.data_sub_type.length; index_sub_type++) {
                 data_gantt.push({
                     id: response.data_sub_type[index_sub_type].id_type + '.' + response.data_sub_type[index_sub_type].id_sub_type,
                     task: response.data_sub_type[index_sub_type].sub_type + '(' + response.data_sub_type[index_sub_type].jml_task + ')',
                     text: response.data_sub_type[index_sub_type].sub_type + '(' + response.data_sub_type[index_sub_type].jml_task + ')',
                     id_status: response.data_sub_type[index_sub_type].id_status,
                     start_date: response.data_sub_type[index_sub_type].start_date,
                     start_date_text: response.data_sub_type[index_sub_type].start_date_text,
                     end_date: response.data_sub_type[index_sub_type].end_date,
                     end_date_text: response.data_sub_type[index_sub_type].end_date_text,
                     duration: response.data_sub_type[index_sub_type].duration,
                     pic: null,
                     progress: response.data_sub_type[index_sub_type].progress,
                     parent: response.data_sub_type[index_sub_type].id_type,
                     open: true
                 })
             }
             for (let index_tickets = 0; index_tickets < response.data_tickets.length; index_tickets++) {
                 if (response.data_tickets[index_tickets].id_task != undefined) {
                     let color_custom = "blue";
                     if (response.data_tickets[index_tickets].id_status == '1') {
                         color_custom = "grey";

                     }

                     if (response.data_tickets[index_tickets].id_status == '2') {
                         color_custom = "#fd7e14";

                     }

                     if (response.data_tickets[index_tickets].id_status == '3') {
                         color_custom = "#91C300";

                     }

                     if (response.data_tickets[index_tickets].id_status == '4') {
                         color_custom = "#f03d4f";

                     }

                     if (response.data_tickets[index_tickets].id_status == '5') {
                         color_custom = "#ffc107";

                     }

                     if (response.data_tickets[index_tickets].id_status == '6') {
                         color_custom = "#fd7e14";

                     }

                     if (response.data_tickets[index_tickets].id_status == '7') {
                         color_custom = "#6f42c1";

                     }
                     data_gantt.push({
                         id: response.data_tickets[index_tickets].id_type + '.' + response.data_tickets[index_tickets].id_sub_type + '.' + response.data_tickets[index_tickets].id_task,
                         task: response.data_tickets[index_tickets].task,
                         text: response.data_tickets[index_tickets].task,
                         id_status: response.data_tickets[index_tickets].id_status,
                         status: `<a role="button" onclick="detail_task('${response.data_tickets[index_tickets].id_task}')" class="badge ${response.data_tickets[index_tickets].status_color}" style="cursor:pointer;">${response.data_tickets[index_tickets].status}</a>`,
                         start_date: response.data_tickets[index_tickets].start_date,
                         start_date_text: response.data_tickets[index_tickets].start_date_text,
                         end_date: response.data_tickets[index_tickets].end_date,
                         end_date_text: response.data_tickets[index_tickets].end_date_text,
                         duration: response.data_tickets[index_tickets].duration,
                         pic: response.data_tickets[index_tickets].pic_name,
                         progress: response.data_tickets[index_tickets].progress,
                         parent: response.data_tickets[index_tickets].id_type + '.' + response.data_tickets[index_tickets].id_sub_type,
                         color: color_custom
                     });
                 }
             }
             gantt.config.columns = [{
                     name: "task",
                     label: "Tickets",
                     tree: true,
                     width: 300,
                     resize: true
                 },
                 {
                     name: "status",
                     label: "Status",
                     width: 80,
                     resize: true,
                 },
                 {
                     name: "start_date_text",
                     label: "Start Time",
                     align: "center",
                     width: 80,
                     resize: true
                 },
                 {
                     name: "end_date_text",
                     label: "End Time",
                     align: "center",
                     width: 80,
                     resize: true
                 },
                 {
                     name: "pic",
                     label: "PIC",
                     width: 100,
                     align: "center",
                     resize: true
                 },
                 {
                     name: "duration",
                     label: "Duration",
                     width: 60,
                     align: "center",
                     resize: true
                 },
                 //  {
                 //      name: "add",
                 //      width: 44
                 //  }
             ];
             gantt.init("gantt_here");
             gantt.clearAll();
             gantt.parse({
                 data: data_gantt,
                 // links: [{
                 //         id: 1,
                 //         source: 1,
                 //         target: 2,
                 //         type: "1"
                 //     },
                 //     {
                 //         id: 2,
                 //         source: 2,
                 //         target: 3,
                 //         type: "0"
                 //     }
                 // ]
             });

         }).fail(function(jqXhr, textStatus) {

         });
     }
 </script>


 <!-- <script>
     var taskData = {
         "data": [{
                 "id": 1,
                 "text": "Office itinerancy",
                 "type": "project",
                 "start_date": "02-04-2019 00:00",
                 "duration": 17,
                 "progress": 0.4,
                 "owner_id": "5",
                 "parent": 0
             },
             {
                 "id": 2,
                 "text": "Office facing",
                 "type": "project",
                 "start_date": "02-04-2019 00:00",
                 "duration": 8,
                 "progress": 0.6,
                 "owner_id": "5",
                 "parent": "1"
             },
             {
                 "id": 3,
                 "text": "Furniture installation",
                 "type": "project",
                 "start_date": "11-04-2019 00:00",
                 "duration": 8,
                 "parent": "1",
                 "progress": 0.6,
                 "owner_id": "5"
             },
             {
                 "id": 4,
                 "text": "The employee relocation",
                 "type": "project",
                 "start_date": "13-04-2019 00:00",
                 "duration": 5,
                 "parent": "1",
                 "progress": 0.5,
                 "owner_id": "5",
                 "priority": 3
             },
             {
                 "id": 5,
                 "text": "Interior office",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 7,
                 "parent": "2",
                 "progress": 0.6,
                 "owner_id": "6",
                 "priority": 1
             },
             {
                 "id": 6,
                 "text": "Air conditioners check",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 7,
                 "parent": "2",
                 "progress": 0.6,
                 "owner_id": "7",
                 "priority": 2
             },
             {
                 "id": 7,
                 "text": "Workplaces preparation",
                 "type": "task",
                 "start_date": "12-04-2019 00:00",
                 "duration": 8,
                 "parent": "3",
                 "progress": 0.6,
                 "owner_id": "10"
             },
             {
                 "id": 8,
                 "text": "Preparing workplaces",
                 "type": "task",
                 "start_date": "14-04-2019 00:00",
                 "duration": 5,
                 "parent": "4",
                 "progress": 0.5,
                 "owner_id": "9",
                 "priority": 1
             },
             {
                 "id": 9,
                 "text": "Workplaces importation",
                 "type": "task",
                 "start_date": "21-04-2019 00:00",
                 "duration": 4,
                 "parent": "4",
                 "progress": 0.5,
                 "owner_id": "7"
             },
             {
                 "id": 10,
                 "text": "Workplaces exportation",
                 "type": "task",
                 "start_date": "27-04-2019 00:00",
                 "duration": 3,
                 "parent": "4",
                 "progress": 0.5,
                 "owner_id": "8",
                 "priority": 2
             },
             {
                 "id": 11,
                 "text": "Product launch",
                 "type": "project",
                 "progress": 0.6,
                 "start_date": "02-04-2019 00:00",
                 "duration": 13,
                 "owner_id": "5",
                 "parent": 0
             },
             {
                 "id": 12,
                 "text": "Perform Initial testing",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 5,
                 "parent": "11",
                 "progress": 1,
                 "owner_id": "7"
             },
             {
                 "id": 13,
                 "text": "Development",
                 "type": "project",
                 "start_date": "03-04-2019 00:00",
                 "duration": 11,
                 "parent": "11",
                 "progress": 0.5,
                 "owner_id": "5"
             },
             {
                 "id": 14,
                 "text": "Analysis",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 6,
                 "parent": "11",
                 "progress": 0.8,
                 "owner_id": "5"
             },
             {
                 "id": 15,
                 "text": "Design",
                 "type": "project",
                 "start_date": "03-04-2019 00:00",
                 "duration": 5,
                 "parent": "11",
                 "progress": 0.2,
                 "owner_id": "5"
             },
             {
                 "id": 16,
                 "text": "Documentation creation",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 7,
                 "parent": "11",
                 "progress": 0,
                 "owner_id": "7",
                 "priority": 1
             },
             {
                 "id": 17,
                 "text": "Develop System",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 2,
                 "parent": "13",
                 "progress": 1,
                 "owner_id": "8",
                 "priority": 2
             },
             {
                 "id": 25,
                 "text": "Beta Release",
                 "type": "milestone",
                 "start_date": "06-04-2019 00:00",
                 "parent": "13",
                 "progress": 0,
                 "owner_id": "5",
                 "duration": 0
             },
             {
                 "id": 18,
                 "text": "Integrate System",
                 "type": "task",
                 "start_date": "10-04-2019 00:00",
                 "duration": 2,
                 "parent": "13",
                 "progress": 0.8,
                 "owner_id": "6",
                 "priority": 3
             },
             {
                 "id": 19,
                 "text": "Test",
                 "type": "task",
                 "start_date": "13-04-2019 00:00",
                 "duration": 4,
                 "parent": "13",
                 "progress": 0.2,
                 "owner_id": "6"
             },
             {
                 "id": 20,
                 "text": "Marketing",
                 "type": "task",
                 "start_date": "13-04-2019 00:00",
                 "duration": 4,
                 "parent": "13",
                 "progress": 0,
                 "owner_id": "8",
                 "priority": 1
             },
             {
                 "id": 21,
                 "text": "Design database",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 4,
                 "parent": "15",
                 "progress": 0.5,
                 "owner_id": "6"
             },
             {
                 "id": 22,
                 "text": "Software design",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 4,
                 "parent": "15",
                 "progress": 0.1,
                 "owner_id": "8",
                 "priority": 1
             },
             {
                 "id": 23,
                 "text": "Interface setup",
                 "type": "task",
                 "start_date": "03-04-2019 00:00",
                 "duration": 5,
                 "parent": "15",
                 "progress": 0,
                 "owner_id": "8",
                 "priority": 1
             },
             {
                 "id": 24,
                 "text": "Release v1.0",
                 "type": "milestone",
                 "start_date": "20-04-2019 00:00",
                 "parent": "11",
                 "progress": 0,
                 "owner_id": "5",
                 "duration": 0
             }

         ],
         "links": [

             {
                 "id": "2",
                 "source": "2",
                 "target": "3",
                 "type": "0"
             },
             {
                 "id": "3",
                 "source": "3",
                 "target": "4",
                 "type": "0"
             },
             {
                 "id": "7",
                 "source": "8",
                 "target": "9",
                 "type": "0"
             },
             {
                 "id": "8",
                 "source": "9",
                 "target": "10",
                 "type": "0"
             },
             {
                 "id": "16",
                 "source": "17",
                 "target": "25",
                 "type": "0"
             },
             {
                 "id": "17",
                 "source": "18",
                 "target": "19",
                 "type": "0"
             },
             {
                 "id": "18",
                 "source": "19",
                 "target": "20",
                 "type": "0"
             },
             {
                 "id": "22",
                 "source": "13",
                 "target": "24",
                 "type": "0"
             },
             {
                 "id": "23",
                 "source": "25",
                 "target": "18",
                 "type": "0"
             }

         ]
     }


     var secondGridColumns = {
         columns: [{
                 name: "status",
                 label: "Status",
                 width: 60,
                 align: "center",
                 template: function(task) {
                     var progress = task.progress || 0;
                     return Math.floor(progress * 100) + "";
                 }
             },
             {
                 name: "impact",
                 width: 80,
                 label: "Impact",
                 template: function(task) {
                     return (task.duration * 1000).toLocaleString("en-US", {
                         style: 'currency',
                         currency: 'USD'
                     });
                 }
             }
         ]
     };

     function calculateResourceLoad(tasks, scale) {
         var step = scale.unit;
         var timegrid = {};

         for (var i = 0; i < tasks.length; i++) {
             var task = tasks[i];

             var currDate = gantt.date[step + "_start"](new Date(task.start_date));

             while (currDate < task.end_date) {

                 var date = currDate;
                 currDate = gantt.date.add(currDate, 1, step);

                 if (!gantt.isWorkTime({
                         date: date,
                         task: task
                     })) {
                     continue;
                 }

                 var timestamp = date.valueOf();
                 if (!timegrid[timestamp])
                     timegrid[timestamp] = 0;

                 timegrid[timestamp] += 8;
             }
         }

         var timetable = [];
         var start, end;
         for (var i in timegrid) {
             start = new Date(i * 1);
             end = gantt.date.add(start, 1, step);
             timetable.push({
                 start_date: start,
                 end_date: end,
                 value: timegrid[i]
             });
         }

         return timetable;
     }


     var renderResourceLine = function(resource, timeline) {
         var tasks = gantt.getTaskBy("user", resource.id);
         var timetable = calculateResourceLoad(tasks, timeline.getScale());

         var row = document.createElement("div");

         for (var i = 0; i < timetable.length; i++) {

             var day = timetable[i];

             var css = "";
             if (day.value <= 8) {
                 css = "gantt_resource_marker gantt_resource_marker_ok";
             } else {
                 css = "gantt_resource_marker gantt_resource_marker_overtime";
             }

             var sizes = timeline.getItemPosition(resource, day.start_date, day.end_date);
             var el = document.createElement('div');
             el.className = css;

             el.style.cssText = [
                 'left:' + sizes.left + 'px',
                 'width:' + sizes.width + 'px',
                 'position:absolute',
                 'height:' + (gantt.config.row_height - 1) + 'px',
                 'line-height:' + sizes.height + 'px',
                 'top:' + sizes.top + 'px'
             ].join(";");

             el.innerHTML = day.value;
             row.appendChild(el);
         }
         return row;
     };

     var resourceLayers = [
         renderResourceLine,
         "taskBg"
     ];

     var mainGridConfig = {
         columns: [{
                 name: "text",
                 tree: true,
                 width: 200,
                 resize: true
             },
             {
                 name: "start_date",
                 align: "center",
                 width: 80,
                 resize: true
             },
             {
                 name: "owner",
                 align: "center",
                 width: 60,
                 label: "Owner",
                 template: function(task) {
                     var store = gantt.getDatastore("resources");
                     var owner = store.getItem(task.user);
                     if (owner) {
                         return owner.label;
                     } else {
                         return "N/A";
                     }
                 }
             },
             {
                 name: "duration",
                 width: 50,
                 align: "center"
             },
             {
                 name: "add",
                 width: 44
             }
         ]
     };

     var resourcePanelConfig = {
         columns: [{
                 name: "name",
                 label: "Name",
                 template: function(resource) {
                     return resource.label;
                 }
             },
             {
                 name: "workload",
                 label: "Workload",
                 template: function(resource) {
                     var tasks = gantt.getTaskBy("user", resource.id);

                     var totalDuration = 0;
                     for (var i = 0; i < tasks.length; i++) {
                         totalDuration += tasks[i].duration;
                     }

                     return (totalDuration || 0) * 8 + "";
                 }
             }
         ]
     };

     gantt.config.layout = {
         css: "gantt_container",
         rows: [{
                 cols: [{
                         view: "grid",
                         group: "grids",
                         config: mainGridConfig,
                         scrollY: "scrollVer"
                     },
                     {
                         resizer: true,
                         width: 1,
                         group: "vertical"
                     },
                     {
                         view: "timeline",
                         id: "timeline",
                         scrollX: "scrollHor",
                         scrollY: "scrollVer"
                     },
                     {
                         view: "scrollbar",
                         id: "scrollVer",
                         group: "vertical"
                     }
                 ]
             },
             {
                 resizer: true,
                 width: 1
             },
             {
                 config: resourcePanelConfig,
                 cols: [{
                         view: "grid",
                         id: "resourceGrid",
                         group: "grids",
                         bind: "resources",
                         scrollY: "resourceVScroll"
                     },
                     {
                         resizer: true,
                         width: 1,
                         group: "vertical"
                     },
                     {
                         view: "timeline",
                         id: "resourceTimeline",
                         bind: "resources",
                         bindLinks: null,
                         layers: resourceLayers,
                         scrollX: "scrollHor",
                         scrollY: "resourceVScroll"
                     },
                     {
                         view: "scrollbar",
                         id: "resourceVScroll",
                         group: "vertical"
                     }
                 ]
             },
             {
                 view: "scrollbar",
                 id: "scrollHor"
             }
         ]
     };

     var resourcesStore = gantt.createDatastore({
         name: "resources",
         initItem: function(item) {
             item.id = item.key || gantt.uid();
             return item;
         }
     });

     var tasksStore = gantt.getDatastore("task");
     tasksStore.attachEvent("onStoreUpdated", function(id, item, mode) {
         resourcesStore.refresh();
     });

     gantt.init("gantt_here");

     resourcesStore.parse([ // resources
         {
             key: '0',
             label: "N/A"
         },
         {
             key: '1',
             label: "John"
         },
         {
             key: '2',
             label: "Mike"
         },
         {
             key: '3',
             label: "Anna"
         }
     ]);

     gantt.parse(taskData);
 </script> -->