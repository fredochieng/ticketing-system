@extends('adminlte::page')
@section('title', 'Issue Categories - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Issues<small>Issue Categories</small></h1>
<div style="clear:both"></div>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Issue Categories</h3>
                <div class="box-tools">
                    <a href="#" data-target="#modal_new_issue_category" data-toggle="modal"
                        class="btn btn-block btn-primary" data-backdrop="static" data-keyboard="false"><i
                            class="fa fa-plus"></i> ADD CATEGORY </a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr role="row">
                                <th>S/N</th>
                                <th>Issue Category</th>
                                <th>Issue Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issueCategories as $count=> $issue)
                            <td>{{$count + 1}}</td>
                            <td>{{$issue->issue_name}}</td>
                            <td>{{$issue->issue_description}}</td>

                            <td> <a href="/issues/manage/&id={{$issue->issue_id}}" class="btn btn-xs btn-primary"><i
                                        class="fa fa-eye"></i>View</a>

                                <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                    data-target="#modal_edit_issue_category_{{$issue->issue_id}}"
                                    class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                                {{Form::hidden('_method','DELETE')}}
                                <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                    data-target="#modal_delete_issue_category_{{$issue->issue_id}}"
                                    class="btn btn-xs btn-danger delete_user_button"><i
                                        class="glyphicon glyphicon-trash"></i> Delete</a>
                            </td>

                            </tr>
                            @include('modals.issues.modal_edit_issue_category')
                            @include('modals.issues.modal_delete_issue_category')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('modals.issues.modal_add_new_issue_category')
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
