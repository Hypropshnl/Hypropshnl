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