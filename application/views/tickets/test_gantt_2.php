<!DOCTYPE html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Gantt chart with resource panel</title>
    <script src="<?= base_url(); ?>assets/gantt/codebase/dhtmlxgantt.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/gantt/codebase/dhtmlxgantt.css">

    <style>
        html,
        body {
            padding: 0px;
            margin: 0px;
            height: 100%;
        }

        .gantt_grid_scale .gantt_grid_head_cell,
        .gantt_task .gantt_task_scale .gantt_scale_cell {
            font-weight: bold;
            font-size: 14px;
            color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>

<body>
    <div id="gantt_here" style='width:100%; height:100%;'></div>
    <script>
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
    </script>
</body>