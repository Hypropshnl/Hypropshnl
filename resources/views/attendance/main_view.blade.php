@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Attendance Records
                    </h2>
                    <ul class="header-dropdown m-r--5">
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
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                    </div>
                                </div>
                            </div>
                            @if(in_array(Auth::user()->role,Utility::HR_MANAGEMENT))
                            <div class="col-sm-3" id="">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control show-tick" multiple id="schedule" name="schedule[]" data-selected-text-format="count">
                                            <option value="">Time Schedule(Multiple)</option>
                                            @foreach($schedule as $ap)
                                                <option value="{{$ap->id}}">{{$ap->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button class="btn btn-info" type="button" onclick="searchReport('searchMainForm','<?php echo url('search_attendance_record'); ?>','reload_data',
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

                                    <th>Name</th>
                                    <th>Clock In</th>
                                    <th>Comment In</th>
                                    <th>Clock In Photo</th>
                                    <th>Status</th>
                                    <th>Late/Shift Request</th>
                                    <th>Request Reason</th>
                                    <th>Clock Out</th>
                                    <th>Comment Out</th>
                                    <th>Clock Out Photo</th>
                                    <th>Day</th>
                                    <th>Date</th>
                                    <th>Work Hr(s)</th>
                                    <th>Over Time(hrs)</th>
                                    <th>Regular Hr(s)</th>
                                    <th>Time Schedule</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($mainData as $data)
                                @php
                                    $timeRequest = (empty($data->time_request)) ? '' : Utility::ATTENDANCE_TIME_REQUEST[$data->timeRequest->type];
                                @endphp
                                <tr>
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                    <td>{{$data->clock_in}}</td>
                                    <td>{{$data->comment}}</td>
                                    <td><img src="{{ asset('images/'.$data->clock_in_photo) }}" class="" width="100" height="100"  alt="User" /></td>
                                    <td>{{Utility::ATTENDANCE_RECORD_STATUS[$data->attendance_status]}}</td>
                                    <td>{{$timeRequest}}</td>
                                    <td>{{$data->timeRequest->reason}}</td>
                                    <td>{{$data->clock_out}}</td>
                                    <td>{{$data->comment_out}}</td>
                                    <td><img src="{{ asset('images/'.$data->clock_out_photo) }}" class="" width="100" height="100"  alt="User" /></td>
                                    <td>{{Utility::getDay($data->day)}}</td>
                                    <td>{{$data->date}}</td>
                                    <td>{{$data->total_hours}}</td>
                                    <td>{{$data->overtime}}</td>
                                    <td>{{$data->regular_hours}}</td>
                                    <td>{{$data->schedule->name}}</td>
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
    </div>

    <!-- #END# Bordered Table -->


@endsection