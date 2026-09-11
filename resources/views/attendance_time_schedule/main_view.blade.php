@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Time Schedule</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <b>Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <b>Geo Tag*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="geo_tag" required>
                                                <option value="">Select GeoTag</option>
                                                @foreach($geoTag as $tag)
                                                <option value="{{$tag->id}}">{{$tag->tag_name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Work Days*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" multiple name="work_days[]" required data-selected-text-format="count">
                                                <option value="">Select Work Days</option>
                                                @foreach(Utility::WEEKDAYS as $key => $var)
                                                <option value="{{$key}}">{{$var}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Time Zone*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="time_zone" required>
                                                <option value="">Select Time Zone</option>
                                                @foreach($timeZone as $tag)
                                                <option value="{{$tag->id}}">{{$tag->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <b>Start Time*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="start_time" placeholder="Start Time" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>End Time</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="end_time" placeholder="End Time" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Start Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" class="form-control" name="start_date" placeholder="Start Date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>End Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" class="form-control" name="end_date" placeholder="End Date" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <b>Lateness Starts After (Mins)*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="late_start_time" placeholder="Lateness Starts After" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Absence Starts After (Mins)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="absence_start_time" placeholder="Absence Starts After" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Notify Users for Lateness After (Number)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="late_count_notify" placeholder="Notify Users for Latenes After" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Notify Users for Absence After (Number)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="absence_count_notify" placeholder="Notify Users for Absence After" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <b>Late Request Start Time</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="late_request_start_time" placeholder="Late Request Start Time" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Late Request End Time</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="late_request_end_time" placeholder="Late Request End Time" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Absence Request Start Time</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="absence_request_start_time" placeholder="Absence Request Start Time" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Absence Request End Time</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="absence_request_end_time" placeholder="Absence Request End Time" required>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <b>Break Start Time</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="break_start_time" placeholder="Break Start Time" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Break End Time</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="break_end_time" placeholder="Break End Time" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Break Period</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="time" class="form-control" name="break_period" placeholder="Break Period" required>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_attendance_time_schedule'); ?>','reload_data',
                            '<?php echo url('attendance_time_schedule'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
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
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_attendance_time_schedule'); ?>','reload_data',
                            '<?php echo url('attendance_time_schedule'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
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
                        Time Schedule
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('attendance_time_schedule'); ?>',
                                    '<?php echo url('delete_attendance_time_schedule'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <div class="body ">
                    <div class="table-responsive" id="reload_data">
                        <table class="table table-bordered table-hover table-striped" id="main_table">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                        name="check_all" class="" />

                                </th>
                                <th>Manage</th>
                                <th>Name</th>
                                <th>Geo Tag</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Work Days</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Lateness Starts After(hrs)</th>
                                <th>Absence Starts After(hrs)</th>
                                <th>Notify Users for Lateness After</th>
                                <th>Notify Users for Absence After</th>
                                <th>Late Request Start Time</th>
                                <th>Late Request End Time</th>
                                <th>Absence Request Start Time</th>
                                <th>Absence Request End Time</th>
                                <th>Created by</th>
                                <th>Updated by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mainData as $data)
                            @php
                                $workDays = json_decode($data->work_days);
                            @endphp
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_attendance_time_schedule_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->name}}</td>
                                <td>{{$data->geoTag->tag_name}}</td>
                                <td>{{$data->start_date}}</td>
                                <td>{{$data->end_date}}</td>
                                <td>
                                    @foreach($workDays as $day)
                                        {{Utility::WEEKDAYS[$day]}}
                                    @endforeach
                                </td>
                                <td>{{$data->start_time}}</td>
                                <td>{{$data->end_time}}</td>
                                <td>{{$data->late_start_time}}</td>
                                <td>{{$data->absence_start_time}}</td>
                                <td>{{$data->late_count_notify}}</td>
                                <td>{{$data->absence_count_notify}}</td>
                                <td>{{$data->late_request_start_time}}</td>
                                <td>{{$data->late_request_end_time}}</td>
                                <td>{{$data->absence_request_start_time}}</td>
                                <td>{{$data->absence_request_end_time}}</td>
                                <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
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
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        //location.hash = page;
    });

    function getData(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getSearchData(page);
        });

        $(document).on('click','.search .pagination a', function(event){
            event.preventDefault();

           /* $('li').removeClass('active');

            $(this).parent('li').addClass('active');

            var myurl = $(this).attr('href');*/

            var page=$(this).attr('href').split('page=')[1];
            getSearchData(page);
            //location.hash = page;
        });

        function getSearchData(page){
            var searchVar = $('#search_attendance_time_schedule').val();

            $.ajax({
                url: '<?php echo url('search_attendance_time_schedule'); ?>?page=' + page +'&searchVar='+ searchVar
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