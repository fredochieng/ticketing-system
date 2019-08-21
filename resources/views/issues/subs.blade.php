@extends('adminlte::page')
@section('title', 'Issue Categories - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Issue<small>{{$issue_name}}</small></h1>
<div style="clear:both"></div>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h4><strong>{{$issue_name}}</strong> - Subcategories</h4>
                <div class="box-tools">
                    <a href="#" data-target="#modal_add_new_issue_subcategory" data-toggle="modal"
                        class="btn btn-block btn-primary" data-backdrop="static" data-keyboard="false"><i
                            class="fa fa-plus"></i> ADD SUBCATEGORY </a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr role="row">
                                <th>S/N</th>
                                <th>Issue Sub Category</th>
                                <th>Issue Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($issueSubCategories as $count=> $sub)
                            <td>{{$count + 1}}</td>
                            <td>{{$sub->issue_subcategory_name}}</td>
                            <td>{{$sub->issue_description}}</td>
                            <td>
                                <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                    data-target="#modal_edit_issue_subcategory_{{$sub->issue_subcategory_id}}"
                                    class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                {{Form::hidden('_method','DELETE')}}
                                <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                    data-target="#modal_delete_issue_subcategory_{{$sub->issue_subcategory_id}}"
                                    class="btn btn-xs btn-danger delete_user_button"><i
                                        class="glyphicon glyphicon-trash"></i> Delete</a>
                                <tr>

                                </tr>
                                @include('modals.issues.modal_edit_issue_subcategory')
                                @include('modals.issues.modal_delete_issue_subcategory')
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('modals.issues.modal_add_new_issue_subcategory')
</div>
@stop
@section('css')

@stop
@section('js')


<script type="text/javascript">
    $(function(){
      $(".select2").select2();
    $('#example1').DataTable()
    });
</script>
@stop
