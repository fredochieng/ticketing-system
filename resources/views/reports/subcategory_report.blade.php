@extends('adminlte::page')
@section('title', 'Issue Subcategories Report - IT Helpdesk')
@section('content_header')
<h1>Issue Subcategories Report</h1>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="table-responsive" style="font-size:14px;">
                    <table class="table table-hover" id="sell_payment_report_table">
                        <thead>
                            <tr style="font-size:12px;">
                                <th>S/N</th>
                                <th>Issue Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issue_categories as $count=> $row)
                            <tr>
                                <td>{{$count + 1}}</td>
                                <td>{{$row->issue_name}}</td>
                                @foreach ($issue_categories as $count=> $row)
                            <tr>
                                <td>{{$count + 1}}</td>
                                <td>{{$row->issue_name}}</td>
                            </tr>
                            @endforeach
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="/plugins/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('js')
<script src="/plugins/jquery/dist/jquery.js"></script>
<script src="/plugins/moment/min/moment.min.js"></script>
<script src="/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/js/select2.full.min.js"></script>

<script>
    $(function () {
      $(".select2").select2();
      $('#example1').DataTable();
    });
</script>
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
@stop