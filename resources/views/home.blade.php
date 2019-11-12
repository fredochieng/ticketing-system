@extends('adminlte::page')
@section('title', 'IT Helpdesk & Ticketing System')
@section('content_header')
<h1>Dashboard</h1>

@stop
@section('content')
<div class="row">
    <a href="tickets/open">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-tags"></i><i class="fa fa-exclamation"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Open Tickets</b></span>
                    <span class="info-box-number">{{ $open_tickets }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width:  {{ $open_per }}%"></div>
                    </div>
                    <span class="progress-description">

                        More info
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <a href="tickets/in-progress">
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-list"></i></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Tickets in progress</b></span>
                    <span class="info-box-number">{{ $in_progress }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $in_progress_per }}%"></div>
                    </div>
                    <span class="progress-description">
                        More info
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </a>
    <a href="tickets/closed">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-ticket"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Closed Tickets</b></span>
                    <span class="info-box-number">{{ $closed }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $closed_per }}%"></div>
                    </div>
                    <span class="progress-description">
                        More info
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </a>
</div>
<input type="hidden" id="open" value="{{ $open_tickets }}">
<input type="hidden" id="in_progress" value="{{ $in_progress }}">
<input type="hidden" id="closed" value="{{ $closed }}">
<input type="hidden" id="esc" value="{{ $esc_tickets }}">
<div class="row">
    <div class="col-md-8">
        <!-- AREA CHART -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Tickets Recap Chart</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="myChart" style="height:340px"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (LEFT) -->
    <div class="col-md-4">
        <!-- Info Boxes Style 2 -->
        <a href="tickets/escalated">
            <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fa fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Escalated Tickets</span>
                    <span class="info-box-number">{{$esc_tickets}}</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        {{-- 50% Increase in 30 Days --}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-desktop"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Tickets opened today</span>
                <span class="info-box-number">{{$today_tickets}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    {{-- 20% Increase in 30 Days --}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Tickets Closed Today</span>
                <span class="info-box-number">{{$today_closed_tickets}}
                </span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    {{-- 70% Increase in 30 Days --}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{$total_users}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    {{-- 40% Increase in 30 Days --}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col (RIGHT) -->
</div>
@if(auth()->user()->can('dashboard.chart'))
<div class="row">
    <div class="col-md-12">
        <!-- AREA CHART -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Daily Tickets Summary
                    {{-- <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div> --}}
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="chartJSContainer" height="300"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endif

@stop
@section('css') @stop @section('js')
<script>
    Chart.defaults.doughnutLabels = Chart.helpers.clone(Chart.defaults.doughnut);

var helpers = Chart.helpers;
var defaults = Chart.defaults;

Chart.controllers.doughnutLabels = Chart.controllers.doughnut.extend({
updateElement: function(arc, index, reset) {
var _this = this;
var chart = _this.chart,
chartArea = chart.chartArea,
opts = chart.options,
animationOpts = opts.animation,
arcOpts = opts.elements.arc,
centerX = (chartArea.left + chartArea.right) / 2,
centerY = (chartArea.top + chartArea.bottom) / 2,
startAngle = opts.rotation, // non reset case handled later
endAngle = opts.rotation, // non reset case handled later
dataset = _this.getDataset(),
circumference = reset && animationOpts.animateRotate ? 0 : arc.hidden ? 0 :
_this.calculateCircumference(dataset.data[index]) * (opts.circumference / (2.0 * Math.PI)),
innerRadius = reset && animationOpts.animateScale ? 0 : _this.innerRadius,
outerRadius = reset && animationOpts.animateScale ? 0 : _this.outerRadius,
custom = arc.custom || {},
valueAtIndexOrDefault = helpers.getValueAtIndexOrDefault;

helpers.extend(arc, {
// Utility
_datasetIndex: _this.index,
_index: index,

// Desired view properties
_model: {
x: centerX + chart.offsetX,
y: centerY + chart.offsetY,
startAngle: startAngle,
endAngle: endAngle,
circumference: circumference,
outerRadius: outerRadius,
innerRadius: innerRadius,
label: valueAtIndexOrDefault(dataset.label, index, chart.data.labels[index])
},

draw: function () {
var ctx = this._chart.ctx,
vm = this._view,
sA = vm.startAngle,
eA = vm.endAngle,
opts = this._chart.config.options;

var labelPos = this.tooltipPosition();
var segmentLabel = vm.circumference / opts.circumference * 100;

ctx.beginPath();

ctx.arc(vm.x, vm.y, vm.outerRadius, sA, eA);
ctx.arc(vm.x, vm.y, vm.innerRadius, eA, sA, true);

ctx.closePath();
ctx.strokeStyle = vm.borderColor;
ctx.lineWidth = vm.borderWidth;

ctx.fillStyle = vm.backgroundColor;

ctx.fill();
ctx.lineJoin = 'bevel';

if (vm.borderWidth) {
ctx.stroke();
}

if (vm.circumference > 0.15) { // Trying to hide label when it doesn't fit in segment
ctx.beginPath();
ctx.font = helpers.fontString(opts.defaultFontSize, opts.defaultFontStyle, opts.defaultFontFamily);
ctx.fillStyle = "#fff";
ctx.textBaseline = "top";
ctx.textAlign = "center";

// Round percentage in a way that it always adds up to 100%
ctx.fillText(segmentLabel.toFixed(0) + "%", labelPos.x, labelPos.y);
}
}
});

var model = arc._model;
model.backgroundColor = custom.backgroundColor ? custom.backgroundColor : valueAtIndexOrDefault(dataset.backgroundColor,
index, arcOpts.backgroundColor);
model.hoverBackgroundColor = custom.hoverBackgroundColor ? custom.hoverBackgroundColor :
valueAtIndexOrDefault(dataset.hoverBackgroundColor, index, arcOpts.hoverBackgroundColor);
model.borderWidth = custom.borderWidth ? custom.borderWidth : valueAtIndexOrDefault(dataset.borderWidth, index,
arcOpts.borderWidth);
model.borderColor = custom.borderColor ? custom.borderColor : valueAtIndexOrDefault(dataset.borderColor, index,
arcOpts.borderColor);

// Set correct angles if not resetting
if (!reset || !animationOpts.animateRotate) {
if (index === 0) {
model.startAngle = opts.rotation;
} else {
model.startAngle = _this.getMeta().data[index - 1]._model.endAngle;
}

model.endAngle = model.startAngle + model.circumference;
}

arc.pivot();
}
});

var open_tickets = $('#open');
var in_progress_tickets = $('#in_progress');
var closed_tickets = $('#closed');

var open_tickets = open_tickets.val();
var in_progress_tickets = in_progress_tickets.val();
var closed_tickets = closed_tickets.val();

var open_tickets = open_tickets;
var in_progress_tickets = in_progress_tickets;
var closed_tickets = closed_tickets;


var config = {
type: 'doughnutLabels',
data: {
datasets: [{
data: [
    open_tickets.valueOf(),
    in_progress_tickets.valueOf(),
    closed_tickets.valueOf(),
],
backgroundColor: [
"#f39c12",
"#00c0ef",
"#3c8dbc"
],
label: 'Dataset 1'
}],
labels: [
"Open Tickets",
"Tickets in progress",
"Closed Tickets"
]
},
options: {
responsive: true,
legend: {
position: 'top',
},
title: {
display: false,
text: 'Tickets Chart'
},
animation: {
animateScale: true,
animateRotate: true
}
}
};

var ctx = document.getElementById("myChart").getContext("2d");
new Chart(ctx, config);

</script>
<script>
    // LINE CAHRT
    Chart.defaults.scale.gridLines.display = false;
    var options = {
        type: 'line',
        data: {
            labels  : <?php echo $all_dates ?>,
            datasets: [
              {
                label               : 'All',
                borderColor         : '#00a65a',
                fillColor           : 'red',
                strokeColor         : 'rgb(218, 107, 222)',
                gridLines:false,
                pointColor          : 'rgb(218, 107, 222)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
               data                :  <?php echo $all_tickets ?>
              },
              {
                label               : 'Open',
                borderColor         : 'orange',
                gridLines:false,
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                :<?php echo $all_open ?>
              },
              {
                label               : 'In Progress',
                borderColor         : '#00c0ef',
                gridLines:false,
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
               data                : <?php echo $all_in_progress ?>
              },
              {
                label               : 'Closed',
                borderColor         : 'blue',
                gridLines:false,
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : <?php echo $all_closed ?>
              }

            ],
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    }]
                }
        },

      }

      var ctx = document.getElementById('chartJSContainer').getContext('2d');
      new Chart(ctx, options);

</script>
@stop