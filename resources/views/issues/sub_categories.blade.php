@extends('issues.index')
@section('title', 'Issue Categories - IT HelpDesk')

@section( 'child_content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        {{-- <div class="box"> --}}
            <div class="box-header">
                <h3 class="box-title">Issue Sub Categories</h3>
                <div class="pull-right">
                    <a href="#modal_add_new_issue_subcategory" data-toggle="modal" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                        ADD ISSUE SUB CATEGORY</a>
                    <a href="#modal_edit_issue_category" data-toggle="modal" class="btn btn-sm btn-success"><i
                            class="fa fa-pencil"></i> EDIT</a>
                    <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                    data-target="#modal_delete_issue_category" class="btn btn-sm btn-danger delete_user_button"><i
                            class="fa fa-trash"></i>
                        DELETE</a>
                </div>

            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="example1" class="table no-margin">
                                        <thead>
                                            <tr role="row">
                                                <th>S/N</th>
                                                <th>Subcategory Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($issueSubCategories as $count=> $issue)
                                            <tr>
                                                <td>{{$count + 1}}</td>
                                                <td>{{$issue->issue_subcategory_name}}</td>
                                                <td>
                                                    <a href="#modal_edit_issue_subcategory_{{$issue->issue_subcategory_id}}"
                                                            data-toggle="modal" class="btn btn-xs btn-success"><i
                                                            class="glyphicon glyphicon-edit"></i> Edit</a>
                                                            {{Form::hidden('_method','DELETE')}}
                                                            <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                                            data-target="#modal_delete_issue_subcategory_{{$issue->issue_subcategory_id}}"
                                                            class="btn btn-xs btn-danger delete_user_button"><i
                                                            class="glyphicon glyphicon-trash"></i>
                                                            Delete</a>
                                                        </td>
                                                    </tr>
                                                    @include('modals.issues.modal_delete_issue_subcategory')
                                                    @include('modals.issues.modal_edit_issue_subcategory')
                                                    @endforeach
                                                </tbody>
                                            </table>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@include('modals.issues.modal_add_new_issue_subcategory')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')

<script src="/js/select2.full.min.js"></script>
<script src="/js/custom.js"></script>

<script>
    $(function () {
      $(".select2").select2();
      $('#example1').DataTable()
    });
</script>
@stop
