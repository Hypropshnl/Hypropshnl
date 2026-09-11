@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Assign Manual Certification</h4>
                </div>
                <div class="modal-body" style="height: 500px; overflow-y: auto;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Offline Course</label>
                                        <div class="form-line">
                                            <select  class="form-control" name="offline_course" >
                                                <option value="" selected>Select Offline Course</option>
                                                @foreach($offlineCourse as $de)
                                                <option value="{{$de->id}}">{{$de->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>User Type(Select Type)</label>
                                        <div class="form-line">
                                            <select  class="form-control show-tick" name="user_type" data-selected-text-format="count">
                                                <option value="{{Utility::P_USER}}" selected>Internal User(s)</option>
                                                <option value="{{Utility::T_USER}}">External User(s)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <div class="form-line">
                                            <input type="text" class="datepicker form-control" autocomplete="off" name="start_date" placeholder="Start Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <div class="form-line">
                                            <input type="text" class="datepicker form-control" autocomplete="off" name="end_date" placeholder="End Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Issue Date</label>
                                        <div class="form-line">
                                            <input type="text" class="datepicker form-control" autocomplete="off" name="issue_date" placeholder="Issue Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Expiry Date</label>
                                        <div class="form-line">
                                            <input type="text" class="datepicker form-control" autocomplete="off" name="expiry_date" placeholder="Expiry Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitDefaultWithItems('createModal','createMainForm','<?php echo url('edit_lms_manual_certification'); ?>','reload_data',
                            '<?php echo url('lms_manual_certification'); ?>','<?php echo csrf_token(); ?>','kid_checkbox')" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i>Update Certification
                    </button>
                    <button type="button" onclick="submitDefaultWithItems('createModal','createMainForm','<?php echo url('create_lms_manual_certification'); ?>','reload_data',
                            '<?php echo url('lms_manual_certification'); ?>','<?php echo csrf_token(); ?>','kid_checkbox_search')" class="btn btn-info">
                        <i class="fa fa-check-square-o"></i>Certify
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
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
                        LMS Manual Certification Assignment
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Certify Users</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('lms_manual_certification'); ?>',
                                    '<?php echo url('delete_lms_manual_certification'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                <div class="body row">
                    <div class="col-md-7">
                        <div class="card header">
                            <h2>Search Users To Certify</h2>
                        </div>
                        <div class="row">
                            <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="col-sm-2" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" multiple id="department" name="department[]" data-selected-text-format="count">
                                                <option value="" selected>Select Department(Multiple)</option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="datepicker form-control" autocomplete="off" id="start_date" name="start_date" placeholder="Created Start Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="datepicker form-control" autocomplete="off" id="end_date" name="end_date" placeholder="Created End Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="normal_user">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Type to Search Internal User (Optional)">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <div class="col-sm-3" id="temp_user" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_users" onkeyup="searchOptionList('select_users','myUL','{{url('default_select')}}','default_search_temp_dept','users');" name="select_user" placeholder="Type to Search External User (Optional)">

                                            <input type="hidden" class="" name="user2" id="users" />
                                        </div>
                                    </div>
                                    <ul id="myUL" class="myUL"></ul>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <input type="checkbox" name="change_user" class="change_user" value="1" onclick="changeUserT('normal_user','temp_user','change_user','user','users');" id="change_user" />Check to search external user(s)
                        
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReport('searchMainForm','<?php echo url('search_lms_manual_certification'); ?>','reload_data_search',
                                                '','<?php echo csrf_token(); ?>')">Search Users</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class=" table-responsive" id="reload_data_search" ></div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card header">
                            <h2>Certified User(s)</h2>
                        </div>
                        <div class="row">
                            <form name="searchAssignForm" id="searchAssignForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" multiple id="department" name="course[]" data-selected-text-format="count">
                                                <option value="" selected>Offline Courses(Multiple)</option>
                                                @foreach($offlineCourse as $de)
                                                    <option value="{{$de->id}}">{{$de->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="normal_user2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user25" onkeyup="searchOptionList('select_user25','myUL25','{{url('default_select')}}','default_search','user25');" name="select_user" placeholder="Type to Search Internal User (Optional)">

                                            <input type="hidden" class="user_class" name="user" id="user25" />
                                        </div>
                                    </div>
                                    <ul id="myUL25" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4" id="temp_user2" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_users26" onkeyup="searchOptionList('select_users26','myUL26','{{url('default_select')}}','default_search_temp_dept','user26');" name="select_user" placeholder="Type to Search External User (Optional)">

                                            <input type="hidden" class="" name="user2" id="users26" />
                                        </div>
                                    </div>
                                    <ul id="myUL26" class="myUL"></ul>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="checkbox" name="change_user" class="change_user2" value="1" onclick="changeUserT('normal_user2','temp_user2','change_user','user2','users2');" id="change_user2" />Check to search external user(s)
                        
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReport('searchAssignForm','<?php echo url('search_user_lms_manual_certification'); ?>','reload_data',
                                                '','<?php echo csrf_token(); ?>')">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class=" table-responsive" id="reload_data" >
                                @include('lms_manual_certification.reload',['mainData' => $mainData])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- #END# Bordered Table -->

@endsection
