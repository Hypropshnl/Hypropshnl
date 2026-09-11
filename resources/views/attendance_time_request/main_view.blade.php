@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Attendance Request</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="type" required data-selected-text-format="count">
                                                <option value="">Select Work Days</option>
                                                @foreach(Utility::ATTENDANCE_TIME_REQUEST as $key => $var)
                                                <option value="{{$key}}">{{$var}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="reason" placeholder="Reason for Request"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="location" id="address_location">
                            </div>
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_attendance_time_request'); ?>','reload_data',
                            '<?php echo url('attendance_time_request'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_attendance_time_request'); ?>','reload_data',
                            '<?php echo url('attendance_time_request'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Attendance Request
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('attendance_time_request'); ?>',
                                    '<?php echo url('delete_attendance_time_request'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="body">
                    <div class="row">
                        <form name="searchMainForm" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                    </div>
                                </div>
                            </div>
                            @if(in_array(Auth::user()->role,Utility::HR_MANAGEMENT))
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                        <input type="hidden" class="user_class" name="user" id="user" />
                                    </div>
                                </div>
                                <ul id="myUL1" class="myUL"></ul>
                            </div>
                            @else
                            <input type="hidden" class="user_class" name="user" value="{{Auth::user()->id}}" />
                            @endif
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <button class="btn btn-info" type="button" onclick="searchReport('searchMainForm','<?php echo url('search_attendance_time_request'); ?>','reload_data',
                                            '','<?php echo csrf_token(); ?>')">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class=" table-responsive" id="reload_data">
                            <table class="table table-bordered table-hover table-striped" id="main_table">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                            name="check_all" class="" />

                                    </th>

                                    <th>Type</th>
                                    <th>Reason</th>
                                    <th>Location</th>
                                    <th>Created by</th>
                                    <th>Updated by</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($mainData as $data)
                                <tr>
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{Utility::ATTENDANCE_TIME_REQUEST[$data->type]}}</td>
                                    <td>{{$data->reason}}</td>
                                    <td>{{$data->location}}</td>
                                    <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                    <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                    <td>{{$data->created_at}}</td>
                                    <td>{{$data->updated_at}}</td>
                                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>
                                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_attendance_time_request_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class=" pagination pull-right">
                                {!! $mainData->render() !!}
                            </div>

                        </div>
                    </div>
                </div>
                

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->


@endsection