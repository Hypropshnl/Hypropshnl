@extends('layouts.app')

@section('content')


<!-- Default Size -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">New Course</h4>
            </div>
            <div class="modal-body">

                <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Course Name
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="course_name" placeholder="Course Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    Course Code
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="course_code" placeholder="Course Code">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    Course Overview
                                    <div class="form-line">
                                        <textarea class="form-control" name="overview" placeholder="Course Overview"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Select Department(s)
                                    <div class="form-line">
                                        <select  class="form-control" multiple name="department[]" >
                                            <option value="">Department(s)</option>
                                            @foreach($dept as $ap)
                                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Select Course Category
                                    <div class="form-line">
                                        <select  class="form-control" name="course_category" >
                                            <option value="">Category</option>
                                            @foreach($lmsCourseCategory as $ap)
                                                <option value="{{$ap->id}}">{{$ap->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Amount
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="amount" placeholder="Amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    Validity (Day(s))
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="validity" placeholder="Validity">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    Hour(s) Per Day
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="hours_per_day" placeholder="Hour(s) Per Day">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    Duration (number of days before expiration)
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="duration" placeholder="Duration">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Certificate Status
                                    <div class="form-line">
                                        <select  class="form-control" name="certificate_status" >
                                            <option value="{{Utility::STATUS_ACTIVE}}">Certificate Status</option>
                                            <option value="{{Utility::STATUS_ACTIVE}}">ACTIVE</option>
                                            <option value="{{Utility::ZERO}}">INACTIVE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Status
                                    <div class="form-line">
                                        <select  class="form-control" name="status" >
                                            <option value="{{Utility::STATUS_ACTIVE}}">ACTIVE</option>
                                            <option value="{{Utility::ZERO}}">INACTIVE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Icon Image
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="icon_image" placeholder="Icon Image">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Certificate Template
                                    <div class="form-line">
                                        <select class="form-control" name="certificate_template_id">
                                            <option value="">Select Template</option>
                                            @foreach($certificateTemplates as $template)
                                                <option value="{{$template->id}}">{{$template->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Organizer One
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name_one" placeholder="Organizer One">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Organizer Two
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name_two" placeholder="Organizer Two">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Organizer One Role
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name_one_role" placeholder="Organizer One Role">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Organizer Two Role
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name_two_role" placeholder="Organizer Two Role">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Organizer One Sign
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="name_one_sign" placeholder="Organizer One Sign">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Organizer Two Sign
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="name_two_sign" placeholder="Organizer Two Sign">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_lms_course'); ?>','reload_data',
                        '<?php echo url('lms_course'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                    SAVE
                </button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
            </div>
            <div class="modal-body" id="edit_content">

            </div>
            <div class="modal-footer">
                <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_lms_course'); ?>','reload_data',
                        '<?php echo url('lms_course'); ?>','<?php echo csrf_token(); ?>')"
                        class="btn btn-info waves-effect">
                    SAVE CHANGES
                </button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size Edit Department Form -->
<div class="modal fade" id="editDeptModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Modify Department(s)</h4>
            </div>
            <ul class="header-dropdown m-r--5 " style="list-style-type: none;">
                <li class="pull-right">
                        <button type="button" onclick="removeAddItem('kid_checkbox_add','reload_data','<?php echo url('lms_course'); ?>',
                                '<?php echo url('modify_lms_course_dept'); ?>','<?php echo csrf_token(); ?>','1','add selected Item(s)','dept_lms_course_id','editDeptModal');" class="btn btn-success">
                            <i class="fa fa-plus"></i>Add
                        </button>
                </li>
                <li>
                    <button type="button" onclick="removeAddItem('kid_checkbox_remove','reload_data','<?php echo url('lms_course'); ?>',
                            '<?php echo url('modify_lms_course_dept'); ?>','<?php echo csrf_token(); ?>','0','remove selected Item(s)','dept_lms_course_id','editDeptModal');" class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>Remove
                    </button>
                </li>
            </ul>
            <div class="modal-body" id="edit_dept_content" style="height: 400px; overflow-y:scroll;">

            </div>
            <div class="modal-footer">

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
                    Course(s)
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li>
                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                    </li>
                    <li>
                        <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('lms_course'); ?>',
                                '<?php echo url('delete_lms_course'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                    <div class="col-sm-8 ">

                        <div class="form-group">

                            <div class="form-line">

                                <input type="text" id="search_course" class="form-control"

                                onkeyup="searchItem('search_course','reload_data','<?php echo url('search_lms_course') ?>','{{url('lms_course')}}','<?php echo csrf_token(); ?>')"

                                name="search_course" placeholder="Search Courses" >

                            </div>
                        </div>
                    </div>
                </div>

                <div class=" table-responsive" id="reload_data" >
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                    name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Manage Department(s)</th>
                            <th>Course Name</th>
                            <th>Enrollees</th>
                            <th>Course Overview</th>
                            <th>Department(s)</th>
                            <th>Course Category</th>
                            <th>Status</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_lms_course_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','edit_dept_content','editDeptModal','<?php echo url('edit_lms_course_dept_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>
                                    @if($data->active_status == 1)

                                    <a href="{{route('lms_lesson', ['course_id' => $data->id])}}">{{$data->name}} ({{$data->code}})</a>

                                    @else

                                        <a href="{{route('lms_lesson', ['course_id' => $data->id])}}">

                                            <span class="alert-warning">{{$data->name}} ({{$data->code}})</span>

                                        </a>

                                    @endif

                                </td>
                                <td><a href="{{route('lms_course_enrollees', ['course_id' => $data->id])}}">View Enrollees</a></td>
                                <td>{{$data->overview}}</td>
                                <td>
                                    @if(!empty($data->dept))
                                        <table>
                                            <tbody>
                                        @foreach($data->dept as $dept)
                                            <tr><td>{{$dept->dept_name}}</td></tr>

                                        @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    {{$data->category->name}}
                                </td>
                                <td>
                                    @if($data->active_status == Utility::STATUS_ACTIVE)
                                    Active
                                    @else
                                    Inactive
                                    @endif
                                </td>
                                <td>
                                {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                </td>
                                <td>
                                {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                </td>
                                <td>{{$data->created_at}}</td>
                                <td>{{$data->updated_at}}</td>
                                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

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

<!-- #END# Bordered Table -->

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

<script>
    /*$(function() {
        $( ".datepicker" ).datepicker({
        /!*changeMonth: true,
        changeYear: true*!/
        });
        });*/
</script>

@endsection