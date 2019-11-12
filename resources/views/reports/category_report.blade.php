@extends('adminlte::page')
@section('title', 'Reports - Tickets Category Report')
@section('content_header')
<h1 class="pull-left">Reports<small>Ticket Category Report</small></h1>

<div style="clear:both"></div>
@stop
@section( 'content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-info" id="accordion">
      <div class="box-header with-border">
        <h3 class="box-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
            <i class="fa fa-filter" aria-hidden="true"></i> Filters
          </a>
        </h3>
      </div>
      <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
        <div class="box-body">
          {!!
          Form::open(['action'=>['ReportController@categoryReport'],
          'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
          !!}
          <div class="col-md-12">

            <div class="col-md-6">
              <div class="form-group">
                {!! Form::label('Date Range') !!}
                {!! Form::text('date_range', null, ['placeholder' => 'Select date range', 'class' =>
                'form-control', 'id' => 'daterange-btn', 'readonly']); !!}
              </div>
            </div>

            <div class="col-md-4">
              <button type="submit" style="margin-top:25px;" class="btn btn-block btn-info"><strong><i
                    class="fa fa-fw fa-search"></i>Generate Report</strong></button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="date_filtered" id="date_filtered" value="{{ $date_filtered }}">
@if($date_filtered == 'Y')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-success">
      <div class="box-header">
      </div>
      <div class="box-body">

        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="position-relative mb-4">
                <canvas id="canvas" height="100"></canvas>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
  @endif
  @stop
  @section('css')
  <link rel="stylesheet" href="/plugins/bootstrap-daterangepicker/daterangepicker.css">
  @stop
  @section('js')
  <script src="/plugins/jquery/dist/jquery.js"></script>
  <script src="/plugins/moment/min/moment.min.js"></script>
  <script src="/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="/js/select2.full.min.js"></script>
  <script src="/js/charts2.0.js"></script>
  <script>
    $(function () {

     //Initialize Select2 Elements
   // $('#example1').DataTable()
     $('.select2').select2()
     //Date range as a button
     $('#daterange-btn').daterangepicker(
       {
         ranges   : {
           'Today'       : [moment(), moment()],
           'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month'  : [moment().startOf('month'), moment().endOf('month')],
           'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
         },
         startDate: moment().subtract(29, 'days'),
         endDate  : moment()
       },
       function (start, end) {
         $('#daterange-btn span').html(start.format('YYYY, MMMM, D') + ' - ' + end.format('YYYY, MMMM, D'))
       }
     )

     var start = "";
     var end = "";
     if ($("input#daterange-btn").val()) {
         start = $("input#daterange-btn")
             .data("daterangepicker")
             .startDate.format("YYYY-MM-DD");
         end = $("input#daterange-btn")
             .data("daterangepicker")
             .endDate.format("YYYY-MM-DD");
     }
     start_date = start;
     end_date = end;
   })
  </script>

  <script>
    var datasets = [];
    
    datasets = addDataset(datasets, <?php echo $all_hardware ?>,
    'Hardware', '#71B37C', '#71B37C', '#71B37C', '#71B37C');

    datasets = addDataset(datasets, <?php echo $all_power_failure ?>,
    'Power Failure', '#71B37C', '#71B37C', '#71B37C', '#71B37C');

    datasets = addDataset(datasets, <?php echo $all_sms ?>,
        'SMS', '#003366', '#003366', '#003366', '#003366');

    datasets = addDataset(datasets, <?php echo $all_pass_reset ?>,
      'Password Reset', '#660080', '#660080', '#660080', '#660080');

    datasets = addDataset(datasets, <?php echo $all_e1_lines ?>,
      'E1 Lines', '#b30000', '#b30000', '#b30000', '#b30000');

    datasets = addDataset(datasets, <?php echo $all_lan ?>,
      'LAN', '#663300', '#663300', '#663300', '#663300');

    datasets = addDataset(datasets, <?php echo $all_new_user_setup ?>,
      'User Setup', '#666633', '#666633', '#666633', '#666633');

    datasets = addDataset(datasets, <?php echo $all_sys_maintenance ?>,
      'System Maintennace', '#ff66cc', '#ff66cc', '#ff66cc', '#ff66cc');

    datasets = addDataset(datasets, <?php echo $all_systems ?>,
      'Systems', '#4287f5', '#4287f5', '#4287f5', '#4287f5');

    datasets = addDataset(datasets, <?php echo $all_internet_conn ?>,
      'Internet Connectivity', '#454e7d', '#454e7d', '#454e7d', '#454e7d');

    datasets = addDataset(datasets, <?php echo $all_user_exit ?>,
      'User Exit', '#00ff00', '#00ff00', '#00ff00', '#00ff00');

    datasets = addDataset(datasets, <?php echo $all_power_failure ?>,
      'Power Failure', '#ff6600', '#ff6600', '#ff6600', '#ff6600');

    datasets = addDataset(datasets, <?php echo $all_general ?>,
      'General', '#cc9900', '#cc9900', '#cc9900', '#cc9900');

    console.log(datasets);

    var barChartData = {
            labels: ["Ticket Issue Categories"],
            datasets: datasets
        };

        function addDataset(datasets, data, label, backgroundColor, borderColor, hoverBackgroundColor, hoverBorderColor) {
          var dataset = JSON.parse(data);
          if(dataset == 0) {
            return datasets;
          }
          datasets.push({
                  type: 'bar',
                  label: label,
                  data: data,
                  fill: false,
                  backgroundColor: backgroundColor,
                  borderColor: borderColor,
                  hoverBackgroundColor: hoverBackgroundColor,
                  hoverBorderColor: hoverBorderColor
                },
          );
          return datasets;
        }
        
        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                responsive: true,
                tooltips: {
                  mode: 'label'
              },
              elements: {
                line: {
                    fill: false
                }
            },
              scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    labels: {
                        show: true,
                    }
                }],
                yAxes: [{
                    type: "linear",
                    display: true,
                    position: "left",
                    minBarLength: 0,
                    gridLines:{
                        display: false
                    },
                    labels: {
                        show:true,
                        
                    }
                }]
            }
            }
            });
        };
  </script>
  </body>
  @stop