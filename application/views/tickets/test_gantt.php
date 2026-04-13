<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .gantt {
            width: 100%;
            margin: 20px auto;
            border: 14px solid #ddd;
            position: relative;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .bar .fn-label {
            display: none;
        }

        .gantt:after {
            content: ".";
            visibility: hidden;
            display: block;
            height: 0;
            clear: both;
        }

        .fn-gantt {
            width: 100%;
        }

        .fn-gantt *,
        .fn-gantt *:after,
        .fn-gantt *:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .fn-gantt .fn-content {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .fn-gantt .row {
            float: left;
            height: 24px;
            line-height: 24px;
            margin: 0;
        }


        /* === LEFT PANEL === */

        .fn-gantt .leftPanel {
            float: left;
            width: 225px;
            overflow: hidden;
            border-right: 1px solid #DDD;
            position: relative;
            z-index: 20;
        }

        .fn-gantt .leftPanel .fn-label {
            display: inline-block;
            margin: 0 0 0 5px;
            color: #484A4D;
            width: 110px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .fn-gantt .leftPanel .row {
            border-bottom: 1px solid #DDD;
        }

        .fn-gantt .leftPanel .name,
        .fn-gantt .leftPanel .desc {
            float: left;
            height: 24px;
            width: 50%;
            background-color: #f6f6f6;
        }

        .fn-gantt .leftPanel .name {
            font-weight: bold;
        }

        .fn-gantt .leftPanel .fn-wide,
        .fn-gantt .leftPanel .fn-wide .fn-label {
            width: 100%;
        }

        .fn-gantt .leftPanel .spacer {
            background-color: #f6f6f6;
            width: 100%;
        }




        /* === RIGHT PANEL === */

        .fn-gantt .rightPanel {
            overflow: hidden;
        }

        .fn-gantt .dataPanel {
            margin-left: 0;
            outline: 1px solid #DDD;
            /* TODO: Replace image with gradient?
        background-size: 24px 24px;
        background-image: linear-gradient(to left, rgba(221, 221, 221, 0.7) 1px, transparent 1px), linear-gradient(to top, rgba(221, 221, 221, 0.7) 1px, transparent 1px);
        */
            background-image: url(/assets/img/grid.png);
            background-repeat: repeat;
            position: relative;
        }

        .fn-gantt .row.header {
            margin-right: -1px;
            width: 100%;
        }

        .fn-gantt .day,
        .fn-gantt .date {
            overflow: visible;
            width: 24px;
            line-height: 24px;
            text-align: center;
            border-right: 1px solid #DDD;
            border-bottom: 1px solid #DDD;
            font-size: 11px;
            color: #484a4d;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.75);
            text-align: center;
        }

        .fn-gantt .sa,
        .fn-gantt .sn,
        .fn-gantt .wd {
            height: 24px;
            text-align: center;
        }

        .fn-gantt .sa,
        .fn-gantt .sn {
            color: #939496;
            background-color: #f5f5f5;
            text-align: center;
        }

        .fn-gantt .wd {
            background-color: #f6f6f6;
            text-align: center;
        }

        .fn-gantt .holiday {
            background-color: #ffd263;
            height: 24px;
        }

        .fn-gantt .today {
            background-color: #fff8da;
            height: 24px;
            font-weight: bold;
            text-align: center;
        }

        .fn-gantt .rightPanel .month,
        .fn-gantt .rightPanel .year {
            float: left;
            overflow: hidden;
            border-right: 1px solid #DDD;
            border-bottom: 1px solid #DDD;
            height: 24px;
            background-color: #f6f6f6;
            font-weight: bold;
            font-size: 11px;
            color: #484a4d;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.75);
            text-align: center;
        }

        .fn-gantt-hint {
            border: 5px solid #edc332;
            background-color: #fff5d4;
            padding: 10px;
            position: absolute;
            display: none;
            z-index: 11;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }

        .fn-gantt .bar {
            background-color: #D0E4FD;
            height: 18px;
            margin: 0 3px 3px 0;
            position: absolute;
            z-index: 10;
            text-align: center;
            -webkit-box-shadow: 0 0 1px rgba(0, 0, 0, 0.25) inset;
            -moz-box-shadow: 0 0 1px rgba(0, 0, 0, 0.25) inset;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.25) inset;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .fn-gantt .bar .fn-label {
            line-height: 18px;
            font-weight: bold;
            white-space: nowrap;
            width: 100%;
            text-overflow: ellipsis;
            overflow: hidden;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.4);
            color: #414B57 !important;
            text-align: center;
            font-size: 11px;
        }

        .fn-gantt .ganttRed {
            background-color: #F9C4E1 !important;
        }

        .fn-gantt .ganttRed .fn-label {
            color: #78436D !important;
        }

        .fn-gantt .ganttGreen {
            background-color: #D8EDA3 !important;
        }

        .fn-gantt .ganttGreen .fn-label {
            color: #778461 !important;
        }

        .fn-gantt .ganttOrange {
            background-color: #FCD29A !important;
        }

        .fn-gantt .ganttOrange .fn-label {
            color: #714715 !important;
        }


        /* === BOTTOM NAVIGATION === */

        .fn-gantt .bottom {
            clear: both;
            background-color: #f6f6f6;
            width: 100%;
        }

        .fn-gantt .navigate {
            border-top: 1px solid #DDD;
            padding: 10px 0 10px 225px;
        }

        .fn-gantt .navigate .nav-slider {
            height: 20px;
            display: inline-block;
        }

        .fn-gantt .navigate .nav-slider-left,
        .fn-gantt .navigate .nav-slider-right {
            text-align: center;
            height: 20px;
            display: inline-block;
        }

        .fn-gantt .navigate .nav-slider-left {
            float: left;
        }

        .fn-gantt .navigate .nav-slider-right {
            float: right;
        }

        .fn-gantt .navigate .nav-slider-content {
            text-align: left;
            width: 160px;
            height: 20px;
            display: inline-block;
            margin: 0 10px;
        }

        .fn-gantt .navigate .nav-slider-bar,
        .fn-gantt .navigate .nav-slider-button {
            position: absolute;
            display: block;
        }

        .fn-gantt .navigate .nav-slider-bar {
            width: 155px;
            height: 6px;
            background-color: #838688;
            margin: 8px 0 0 0;
            -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.6) inset;
            -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.6) inset;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.6) inset;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .fn-gantt .navigate .nav-slider-button {
            width: 17px;
            height: 60px;
            background: url(/assets/img/slider_handle.png) center center no-repeat;
            left: 0;
            top: 0;
            margin: -26px 0 0 0;
            cursor: pointer;
        }

        .fn-gantt .navigate .page-number {
            display: inline-block;
            font-size: 10px;
            height: 20px;
        }

        .fn-gantt .navigate .page-number span {
            color: #666666;
            margin: 0 6px;
            height: 20px;
            line-height: 20px;
            display: inline-block;
        }

        .fn-gantt .navigate a:link,
        .fn-gantt .navigate a:visited,
        .fn-gantt .navigate a:active {
            text-decoration: none;
        }

        .fn-gantt .nav-link {
            margin: 0 3px 0 0;
            display: inline-block;
            width: 20px;
            height: 20px;
            font-size: 0;
            background: #595959 url(/assets/img/icon_sprite.png) !important;
            border: 1px solid #454546;
            cursor: pointer;
            vertical-align: top;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 1px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 1px rgba(0, 0, 0, 0.2);
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 1px rgba(0, 0, 0, 0.2);
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .fn-gantt .nav-link:active {
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.25) inset, 0 1px 0 #FFF;
            -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.25) inset, 0 1px 0 #FFF;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.25) inset, 0 1px 0 #FFF;
        }

        .fn-gantt .navigate .nav-page-back {
            background-position: 1px 0 !important;
            margin: 0;
        }

        .fn-gantt .navigate .nav-page-next {
            background-position: 1px -16px !important;
            margin-right: 15px;
        }

        .fn-gantt .navigate .nav-slider .nav-page-next {
            margin-right: 5px;
        }

        .fn-gantt .navigate .nav-begin {
            background-position: 1px -112px !important;
        }

        .fn-gantt .navigate .nav-prev-week {
            background-position: 1px -128px !important;
        }

        .fn-gantt .navigate .nav-prev-day {
            background-position: 1px -48px !important;
        }

        .fn-gantt .navigate .nav-next-day {
            background-position: 1px -64px !important;
        }

        .fn-gantt .navigate .nav-next-week {
            background-position: 1px -160px !important;
        }

        .fn-gantt .navigate .nav-end {
            background-position: 1px -144px !important;
        }

        .fn-gantt .navigate .nav-zoomOut {
            background-position: 1px -96px !important;
        }

        .fn-gantt .navigate .nav-zoomIn {
            background-position: 1px -80px !important;
            margin-left: 15px;
        }

        .fn-gantt .navigate .nav-now {
            background-position: 1px -32px !important;
        }

        .fn-gantt .navigate .nav-slider .nav-now {
            margin-right: 5px;
        }

        .fn-gantt-loader {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#bf000000', endColorstr='#bf000000', GradientType=0);
            background: rgba(0, 0, 0, 0.75);
            cursor: wait;
            z-index: 30;
        }

        .fn-gantt-loader-spinner span {
            position: absolute;
            margin: auto;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            height: 1em;
            line-height: 1em;
            color: #fff;
            font-size: 1em;
            font-weight: bold;
        }

        .row:after {
            clear: both;
        }
    </style>
</head>

<body>
    <div id="gantt" class="gantt"></div>
</body>
<script src="https://trusmiverse.com/apps/assets/js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url(); ?>/assets/simple_jquery_gantt_chart/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/simple_jquery_gantt_chart/js/jquery.fn.gantt.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
<script>
    $(".gantt").gantt({
        source: [{
            name: "Sprint 0",
            desc: "Analysis",
            values: [{
                from: "/Date(1320192000000)/",
                to: "/Date(1322401600000)/",
                label: "Requirement Gathering",
                customClass: "ganttRed"
            }]
        }, {
            name: " ",
            desc: "Scoping",
            values: [{
                from: "/Date(1322611200000)/",
                to: "/Date(1323302400000)/",
                label: "Scoping",
                customClass: "ganttRed"
            }]
        }, {
            name: "Sprint 1",
            desc: "Development",
            values: [{
                from: "/Date(1323802400000)/",
                to: "/Date(1325685200000)/",
                label: "Development",
                customClass: "ganttGreen"
            }]
        }, {
            name: " ",
            desc: "Showcasing",
            values: [{
                from: "/Date(1325685200000)/",
                to: "/Date(1325695200000)/",
                label: "Showcasing",
                customClass: "ganttBlue"
            }]
        }, {
            name: "Sprint 2",
            desc: "Development",
            values: [{
                from: "/Date(1326785200000)/",
                to: "/Date(1325785200000)/",
                label: "Development",
                customClass: "ganttGreen"
            }]
        }, {
            name: " ",
            desc: "Showcasing",
            values: [{
                from: "/Date(1328785200000)/",
                to: "/Date(1328905200000)/",
                label: "Showcasing",
                customClass: "ganttBlue"
            }]
        }, {
            name: "Release Stage",
            desc: "Training",
            values: [{
                from: "/Date(1330011200000)/",
                to: "/Date(1336611200000)/",
                label: "Training",
                customClass: "ganttOrange"
            }]
        }, {
            name: " ",
            desc: "Deployment",
            values: [{
                from: "/Date(1336611200000)/",
                to: "/Date(1338711200000)/",
                label: "Deployment",
                customClass: "ganttOrange"
            }]
        }, {
            name: " ",
            desc: "Warranty Period",
            values: [{
                from: "/Date(1336611200000)/",
                to: "/Date(1349711200000)/",
                label: "Warranty Period",
                customClass: "ganttOrange"
            }]
        }],
        dow: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
        navigate: "scroll",
        maxScale: "hours",
        itemsPerPage: 10,
        onItemClick: function(data) {
            alert("Item clicked - show some details");
        },
        onAddClick: function(dt, rowId) {
            alert("Empty space clicked - add an item!");
        },
        onRender: function() {
            if (window.console && typeof console.log === "function") {
                console.log("chart rendered");
            }
        }
    });

    $(".gantt").popover({
        selector: ".bar",
        title: "I'm a popover",
        content: "And I'm the content of said popover.",
        trigger: "hover"
    });

    prettyPrint();
</script>